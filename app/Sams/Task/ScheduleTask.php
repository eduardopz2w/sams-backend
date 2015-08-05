<?php

namespace Sams\Task;

use Sams\Manager\ValidationException;
use Sams\Repository\ScheduleRepository;

class ScheduleTask {

	protected $scheduleRepository;

	public function __construct(ScheduleRepository $scheduleRepository)

	{
			$this->scheduleRepository = $scheduleRepository;
	}

	public function scheduleConfirmed($hourIn, $hourOut, $days, $employee)

	{
		  $this->scheduleIntervalDay($hourIn, $hourOut, $employee->id, $days);
		  $this->schedulesBetweenDifferences($hourIn, $days);

			$schedule = $this->scheduleRepository->getScheduleForData($hourIn, $hourOut, $days);

			if ($schedule->count() > 0)

			{
					$schedule = $schedule->first();
					$this->confirmScheduleEmploye($schedule->id, $employee->id);
					$employee->schedules()->attach($schedule->id);

					return false;
			}

			return true;
	}

	public function confirmScheduleEmploye($idS,$idE)

	{
			$scheduleInEmployee = $this->scheduleRepository->scheduleInEmployee($idS, $idE);

			if ($scheduleInEmployee->count() > 0)

			{
					$message = 'Empleado ya posee este horario';
					$this->hasException($message);
			}
	}

	public function scheduleIntervalDay($hourIn, $hourOut, $idEmploye, $days)

	{
		  $scheduleInterval = $this->scheduleRepository->intervalSchedule($hourIn, $hourOut);

		  if ($scheduleInterval->count() > 0)

		  {
		  		$scheduleInterval = $scheduleInterval->get();

		  		foreach ($scheduleInterval as $schedule) 
		  		
		  		{ 
		  				$scheduleEmployee = $this->scheduleRepository->scheduleInEmployee($schedule->id, $idEmploye);

		  				if ($scheduleEmployee->count() > 0)

		  				{
		  					  $this->confirmDay($schedule->days, $days);
		  				}
		  		}
		  }
	}

	public function schedulesBetweenDifferences($hour, $days)

	{
			$hourDiscount = $this->hourDiscount($hour);
			$discount = $this->scheduleRepository->scheduleBetweenDifferences($hourDiscount, $hour);

			if ($discount->count() > 0)

			{
					$discount = $discount->first();
					$this->confirmDay($discount->days, $days);
			}
	}

	public function confirmDay($daySchedule, $days)

	{
			$segmentDay = explode(' ', $days);
			
			foreach($segmentDay as $day)

			{
					if(str_contains($daySchedule, $day)) 

					{
							$message = 'Horas asignadas no deben redundar con la de otros horarios';
		  				$this->hasException($message);
					}
			}
	}



	public function hourDiscount($hour)

	{
			$hour = strtotime($hour);

			$hourDiscount = date('H:i', strtotime('-30 minutes', $hour));
			return $hourDiscount;
	}

	public function hasException($message)

	{
			throw new ValidationException("Error Processing Request", $message);
			
	}

}