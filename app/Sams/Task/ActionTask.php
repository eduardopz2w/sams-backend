<?php

namespace Sams\Task;

use Sams\Repository\EmployeeRepository;
use Sams\Repository\ActionRepository;
use Sams\Repository\ScheduleRepository;
use Sams\Task\EmployeeTask;
use Sams\Task\AttendanceTask;

class ActionTask extends BaseTask {
	 
	protected $actionRepo;
	protected $employeRepo;
	protected $scheduleRepo;
  protected $employeTask;
  protected $attendanceTask;

	public function __construct(EmployeeRepository $employeeRepo, EmployeeTask $employeTask,
		                          ActionRepository $actionRepo, ScheduleRepository $scheduleRepo,
		                          AttendanceTask  $attendanceTask)

	{
		  $this->actionRepo     = $actionRepo;
			$this->employeeRepo   = $employeeRepo;
			$this->scheduleRepo   = $scheduleRepo;
			$this->employeTask    = $employeTask;
			$this->attendanceTask = $attendanceTask;
	}

	public function confirmedEmployee($idEmployee)

	{
			if (!empty($idEmployee))

			{
					$employee = $this->employeeRepo->find($idEmployee);
					$this->employeTask->employeeNotFound($employee);
					$this->employeTask->employeeActiviti($employee);
			}
	}


	public function confirmedType($action)

	{
		  $hourIn  = $action->hour_in;
		  $hourOut = $action->hour_out;

		  if ($action->type == 'special' && !empty($hourIn) && !empty($hourOut))

		  {
		  		if ($hourOut <= $hourIn)

					{
							$message = 'Hora de culminacion debe ser mayor a hora de inicio';
							$this->hasException($message);
					}
		  }
	}

	public function confirmedAction($action)

	{
			if (!$action->state)

			{
					$message = 'Actualmente no se realiza esta actividad';
					$this->hasException($message);
			}
	}

	
	public function getActionNormal($date)

	{
		  $day = date_day($date);

			$actionNormal = [];
			$schedules    = $this->scheduleRepo->timesToday($day);

			if ($schedules->count() > 0)

			{
					$schedules = $schedules->get();

					$this->getActionForSchedule($schedules, $actionNormal, $date);
			}

			$response = $this->stateAction(count($actionNormal), $actionNormal);

			return $response;
	}

	public function getActionForSchedule($schedules, &$actionNormal, $date)

	{
			foreach ($schedules as $schedule) 

			{
				 $actions = $schedule->actions;

				 foreach ($actions as $action) 

				 {
				 	   $assingSchedule = $action->pivot->created_at;
				 	   $actionInDate   = $this->attendanceTask->entityInDate($assingSchedule , $date);
             
				 		 if ($action->state && $actionInDate)

				 		 {
				 		 	  $action->employee;  
                $action->hour_in = $schedule->entry_time;
                $action->hour_out  = $schedule->departure_time;

				 		 		array_push($actionNormal, $action);
				 		 }

				 }
			}
	}

	public function getActionSpecial($date)

	{
			$actionSpecial = $this->actionRepo->getActionSpecial($date);

			$count = $actionSpecial->count();

			if ($count > 0)

			{
					$actionSpecial = $actionSpecial->get();
			}

			$response = $this->stateAction($count, $actionSpecial);

			return $response;
	}

	public function stateAction($count, $actions)

	{

			if ($count == 0)

			{
					return ['status'  => 'error',
					        'message' => 'No hay actividades'];
			}

			else

			{
					return ['status'  => 'success',
					        'data'    => $actions];
			}
	}



}