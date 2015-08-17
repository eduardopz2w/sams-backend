<?php

namespace Sams\Task;

use Sams\Manager\ScheduleManager;
use Sams\Repository\ScheduleRepository;
use Sams\Repository\EmployeeRepository;
use Sams\Repository\ActionRepository;

class ScheduleTask extends BaseTask {

	protected $scheduleRepo;
	protected $employeeRepo;
	protected $actionRepo;

	public function __construct(ScheduleRepository $scheduleRepo, ActionRepository $actionRepo,
		                          EmployeeRepository $employeeRepo)

	{
			$this->scheduleRepo = $scheduleRepo;
			$this->employeeRepo = $employeeRepo;
			$this->actionRepo   = $actionRepo;
	}

	public function addSchedule($entity, $data, $isEmployee, $timeBreak)

	{
			$schedule = $this->scheduleRepo->getModel();
			$manager  = new ScheduleManager($schedule, $data);
						
			$manager->validateSchedule($timeBreak);

			$days = $manager->getDays();
				
			$scheduleConfirmed = $this->scheduleConfirmed($data, $days, $entity, $isEmployee);
			
			if ($scheduleConfirmed)

			{
				  $idSchedule = $manager->save();
				  $entity->schedules()->attach($idSchedule);
			}

			$respose = ['status'  => 'success',
			            'message' => 'horario almacenado'];

			return $respose;
	}

	public function scheduleConfirmed($data, $days, $entity, $isEmployee)

	{
		  $hourIn   = $data['entry_time'];
			$hourOut  = $data['departure_time'];

		  $this->scheduleIntervalDay($hourIn, $hourOut, $entity, $days, $isEmployee);

			$schedule = $this->scheduleRepo->getScheduleForData($hourIn, $hourOut, $days);

			if ($schedule->count() > 0)

			{
					$schedule = $schedule->first();
					$entity->schedules()->attach($schedule->id);

					return false;
			}

			return true;
	}


	public function scheduleIntervalDay($hourIn, $hourOut, $entity, $days, $isEmployee)

	{
		  $id = $entity->id;

			if ($isEmployee)

			{
					$message = 'horas asignadas no deben interferir con otros horarios';
					$entity  = $this->employeeRepo->employeeInSchedule($id, $hourIn, $hourOut, $days);

					$this->confirmHour($entity, $message);
			}

			else

			{
					$idEmployee = $entity->employee_id;
					$message    = 'horas de actividad no deben redundar';
					$entity     = $this->actionRepo->actionInSchedule($id, $hourIn, $hourOut, $days);
					
					$this->confirmHour($entity, $message);
					$this->confirmEmployeeHourActivity($idEmployee, $hourIn, $hourOut, $days);
			}

	}

	public function confirmHour($entity, $message)

	{
			foreach ($entity as $e) 

			{
				  $schedules = $e->schedules;

				  if (count($schedules) > 0)

				  {
				  		$this->hasException($message);
				  }

				  break;
			}
	}

	public function confirmEmployeeHourActivity($idEmployee, $hourIn, $hourOut, $days)

	{
			if (!is_null($idEmployee))

			{
					$entity = $this->actionRepo->scheduleInActioneEmployee($idEmployee, $hourIn, $hourOut, $days);

					foreach ($entity as $e) 

			    {
				 	    $schedules = $e->schedules;

				 	    if (count($schedules) > 0)

				 	    {
				 			   $message = 'Empleado tiene actividad entre las horas asignadas';
				 			   $this->hasException($message);
				 	    }

				 	    break;
			    }
			}
	}


}