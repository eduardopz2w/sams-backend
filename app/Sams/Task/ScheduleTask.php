<?php

namespace Sams\Task;

use Sams\Repository\ScheduleRepository;
use Sams\Repository\ActionRepository;

class ScheduleTask extends BaseTask {

	protected $scheduleRepo;
	protected $actionRepo;

	public function __construct(ScheduleRepository $scheduleRepo, ActionRepository $actionRepo)

	{
			$this->scheduleRepo = $scheduleRepo;
			$this->actionRepo   = $actionRepo;
	}

	public function scheduleConfirmed($hourIn, $hourOut, $days, $entity, $isEmployee)

	{
		  $this->scheduleIntervalDay($hourIn, $hourOut, $entity->id, $days, $isEmployee);
		  // $this->schedulesBetweenDifferences($hourIn, $days);

			$schedule = $this->scheduleRepo->getScheduleForData($hourIn, $hourOut, $days);

			if ($schedule->count() > 0)

			{
					$schedule = $schedule->first();
					$this->confirmScheduleEntity($schedule->id, $entity->id, $isEmployee);
					$entity->schedules()->attach($schedule->id);

					return false;
			}

			return true;
	}

	public function confirmScheduleEntity($idS,$idE, $isEmployee)

	{
			$scheduleInEntity = $this->inEntitiy($idS, $idE, $isEmployee);

			if ($scheduleInEntity->count() > 0)

			{
					$message = 'Ya posee este horario';
					$this->hasException($message);
			}
	}

	public function scheduleIntervalDay($hourIn, $hourOut, $idEntity, $days, $isEmployee)

	{

		  $scheduleInterval = $this->scheduleRepo->intervalSchedule($hourIn, $hourOut);

		  if ($scheduleInterval->count() > 0)

		  {
		  		$scheduleInterval = $scheduleInterval->get();

		  		foreach ($scheduleInterval as $schedule) 
		  		
		  		{ 
              $scheduleInEntity = $this->inEntitiy($schedule->id, $idEntity, $isEmployee);

		  				if ($scheduleInEntity->count() > 0)

		  				{
		  					  $this->confirmDay($schedule->days, $days);
		  				}
		  		}
		  }
	}

	public function inEntitiy($idSchedule, $idEntity, $isEmployee)

	{
			if ($isEmployee)

			{
					$scheduleInEmployee = $this->scheduleRepo->scheduleInEmployee($idSchedule, $idEntity);
					return $scheduleInEmployee;
			}

			else

			{
					$scheduleInAction = $this->scheduleRepo->scheduleInAction($idSchedule, $idEntity);
					return $scheduleInAction;
			}
	}

	public function confirmDay($daySchedule, $days)

	{
			$segmentDay = explode(' ', $days);
			
			foreach($segmentDay as $day)

			{
					if(str_contains($daySchedule, $day)) 

					{
						  
						  $message = 'Horas asignadas no deben interferir con otros horarios';
		  				$this->hasException($message);
						  
					}
			}
	}


	// public function schedulesBetweenDifferences($hour, $days)

	// {
	// 		$hourDiscount = $this->hourDiscount($hour);
	// 		$discount = $this->scheduleRepo->scheduleBetweenDifferences($hourDiscount, $hour);

	// 		if ($discount->count() > 0)

	// 		{
	// 			  $diff     = true;
	// 				$discount = $discount->first();
	// 				$confirm  = $this->confirmDay($discount->days, $days, $diff);
					
	// 				if ($confirm)

	// 				{
	// 						$hour     = hour_usual($discount->departure_time);
	// 						$message  = 'Se tiene horario que termina a las '.$hour.' los horarios deben tener diferencia de 30 minutos';
	// 						$this->hasException($message);
	// 				} 
	// 		}
	// }


	public function hourDiscount($hour)

	{
			$hour = strtotime($hour);

			$hourDiscount = date('H:i', strtotime('-29 minutes', $hour));
			return $hourDiscount;
	}

}