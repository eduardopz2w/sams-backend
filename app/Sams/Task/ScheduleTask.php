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

  public function __construct(ScheduleRepository $scheduleRepo, 
  	                          ActionRepository $actionRepo,
		                          EmployeeRepository $employeeRepo) {
  	$this->scheduleRepo = $scheduleRepo;
	  $this->employeeRepo = $employeeRepo;
	  $this->actionRepo   = $actionRepo;
  }

	public function addSchedule($entity, $data, $isEmployee, $timeBreak) {
		$schedule = $this->scheduleRepo->getModel();
	  $manager = new ScheduleManager($schedule, $data);
						
	  $manager->validateSchedule($timeBreak);

	  $days = $manager->getDays();
		$scheduleConfirmed = $this->scheduleConfirmed($data, $days, $entity, $isEmployee);

		if ($scheduleConfirmed) {
			$manager->save();
		  $entity->schedules()->attach($schedule->id);
		}

		$response = [
		 'status' => 'success',
		 'message' => 'Horario registrado'
		];

		return $response;
	}

	public function scheduleConfirmed($data, $days, $entity, $isEmployee) {
		$hourIn = $data['entry_time'];
    $hourOut = $data['departure_time'];

    $this->scheduleIntervalDay($hourIn, $hourOut, $entity, $days, $isEmployee);

	  $schedule = $this->scheduleRepo->getScheduleForData($hourIn, $hourOut, $days);

	  if ($schedule->count() > 0) {
	  	$schedule = $schedule->first();

		  $entity->schedules()->attach($schedule->id);

		  return false;
	  }

		return true;
	}
	  
	public function scheduleIntervalDay($hourIn, $hourOut, $entity, $days, $isEmployee) {
	  $id = $entity->id;

	  if ($isEmployee) {
	  	$message = 'Dias y horas interfieren con otros horarios';
		  $entity  = $this->employeeRepo->employeeInSchedule($id, $hourIn, $hourOut, $days);

		  $this->confirmHour($entity, $message);
	  } else {
	  	$message = 'Dias y horas de actividad no deben interferir con otros horarios';
		  $entity = $this->actionRepo->actionInSchedule($id, $hourIn, $hourOut, $days);

		  $this->confirmHour($entity, $message);
	  }

	}

	public function confirmHour($entity, $message) {
		foreach ($entity as $e) {
			$schedules = $e->schedules;

			if (count($schedules) > 0) {
				$this->hasException($message);
			}

			break;
		}
	}


}