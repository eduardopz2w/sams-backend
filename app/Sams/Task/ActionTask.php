<?php

namespace Sams\Task;

use Sams\Repository\EmployeeRepository;
use Sams\Repository\ActionRepository;
use Sams\Repository\ScheduleRepository;

class ActionTask extends BaseTask {
	 
	protected $actionRepo;
	protected $scheduleRepo;
  protected $employeeTask;
  protected $attendanceTask;

	public function __construct(ActionRepository $actionRepo, ScheduleRepository $scheduleRepo,
		                          AttendanceTask  $attendanceTask, EmployeeTask $employeeTask)

	{
		  $this->actionRepo     = $actionRepo;
			$this->scheduleRepo   = $scheduleRepo;
			$this->employeeTask   = $employeeTask;
			$this->attendanceTask = $attendanceTask;
	}

	public function confirmedEmployee(&$data)

	{
	    if (!empty($data['employee_ident']))

			{

			    $employee = $this->employeeTask->findEmployeeByCredentials($data['employee_ident']);

			 		if ($employee)

			 		{
			 		 	  $data = array_add($data, 'employee_id', $employee->id);
			 		}
			}
	}


	public function confirmData($data)

	{
		  $hourIn      = $data['hour_in'];
		  $hourOut     = $data['hour_out'];
		  $type        = $data['type'];
		  $description = $data['description'];

		  if ($type == 'special'  && !empty($hourIn) && !empty($hourOut))

		  {
		      if ($hourOut <= $hourIn)

				  {
					   $message = 'Hora de inicio debe ser menor a hora de fin';
						 $this->hasException($message);
				  }
		  }
	    

	    $this->actionExist($type, $description);
  }

  public function actionExist($type, $description)

  {
  	  $description =  scapeText($description);

  		if ($type == 'normal')

  		{
  				$action = $this->actionRepo->actionForDescription($description);

  				if ($action->count() > 0)

  				{
  						$message = 'Actividad ya existe';
  						$this->hasException($message);
  				}
  		}
  }

	public function confirmedAction($id)

	{
		  $action = $this->actionRepo->find($id);

			if (!$action->state)

			{
					$message = 'Actualmente no se realiza esta actividad';
					$this->hasException($message);
			}

			return $action;
	}

	public function getActionNormal($date)

	{
		  $day          = date_day($date);
			$schedules    = $this->scheduleRepo->scheduleInActionDay($day);
			$actionNormal = [];

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
                $action->hour_in  = $schedule->entry_time;
                $action->hour_out = $schedule->departure_time;
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