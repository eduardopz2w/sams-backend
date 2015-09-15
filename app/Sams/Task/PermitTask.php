<?php

namespace Sams\Task;

use Sams\Repository\EmployeeRepository;

class PermitTask extends BaseTask {

	protected $permitRepo;
	protected $employeeRepo;

	public function __construct(EmployeeRepository $employeeRepo) {
		$this->employeeRepo = $employeeRepo;
	}

	public function confirmedPermit($permit) {
		$this->confirmDate($permit);

		$segments = explode('-', $permit->date_start);
	  $firstDay = first_day_month($segments[1], date('Y'));
	  $lastDay = last_day_month($segments[1], date('Y'));
	  $config = get_configuration();
	  $month = \Lang::get('utils.months_number.'.$segments[1]);
	  $maxPermit = $config->max_permits;
	  $employee = $permit->employee;
	 	$permitTotal = $employee
	  								->permits()
	  									->where('date_start', '>=', $firstDay)
	 		           			->where('date_start', '<=', $lastDay)
	  							  	->where('state', '<>', 'cancelado');

	  if ($permitTotal->count() == $maxPermit) {
		  $message = 'Empleado ha usado la cantidad maxima de '.$maxPermit.' permisos por el mes de '.$month;

		  $this->hasException($message);
	  }

		$this->permissonAccordingType($permit, $employee);

	}

	public function confirmDate($permit) {
		$type = $permit->type;
		$dateIn = $permit->date_start;
		$dateEnd = $permit->date_end;
		
		if ($type == 'extend') {
			if ($dateIn >= $dateEnd) {
				$message = 'Ingrese fechas correctamente';

	  		$this->hasException($message);
			}
		}
	}

	public function permissonAccordingType($permit, $employee) {
		$dateIn = $permit->date_start;
		$dateEnd = $permit->date_end;
		$turn = $permit->turn;
		$type = $permit->type;

		if ($type == 'normal') {
		  $permitDay = $employee
		  							->permits()
		  								->where('date_start', $dateIn)
		  								->where('turn', $turn)
		  								->where('state', '<>', 'cancelado')
		  								->orWhere(function ($query) use ($dateIn) {
		  										$query->where('date_start', $dateIn)
		  													->where('turn', 'complete')
		  													->where('state', '<>', 'cancelado');
		  								 });

		  if ($permitDay->count() > 0) {
		  	$message = 'Empleado ya tiene permiso para este turno';

		  	$this->hasException($message);
		  }

		  $this->permitRegularBetween($employee, $dateIn);

		  $employeeId = $employee->id;

		  $this->checkSchedule($employeeId, $dateIn, $turn);
		} else {
		  $this->permitExtendBetween($employee, $dateIn, $dateEnd);
		}
	}

	public function permitRegularBetween($employee, $dateIn) {
		$permitBetween = $employee
												->permits()
												 ->where('date_start', '<=', $dateIn)
												 ->where('date_end', '>=', $dateIn)
												 ->where('state', '<>', 'cancelado');

		if ($permitBetween->count() > 0) {
			$permitBetween = $permitBetween->first();
		  $dateInt = $permitBetween->date_start;
		  $dateEnd = $permitBetween->date_end;
		  $message = 'Empleado con permiso desde '.$dateInt.' hasta '.$dateEnd. ' ingrese dia fuera del periodo';

			$this->hasException($message);
		}
	}

	public function checkSchedule($employeeId, $dateIn, $turn) {
    $day = date_day($dateIn);
    $employee = $this->employeeRepo->employeeInScheduleDay($employeeId, $day);
    $message = 'Verifique fecha y turno';

		foreach ($employee as $e) {
		  $schedules = $e->schedules;

			if (count($schedules) == 0) {
				$this->hasException($message);
			}

			break;
		}
    
		if ($turn != 'complete') {
    	$this->confirmSchedule($schedules, $turn, $message);
		}
			
	}

	public function confirmSchedule($schedules, $turn, $message) {
    $confirm = false;

    foreach ($schedules as $schedule) {
    	$hourIn = $schedule->entry_time;
      $hourOut = $schedule->departure_time;
      $turnHours = $this->confirmTurn($hourIn, $hourOut);

      if ($turnHours == $turn || $turn != 'night' && $turnHours == 'double') {
        $confirm = true;

        break;
      }
    }

    if (!$confirm) $this->hasException($message);
	}

	public function confirmTurn($hourIn, $hourOut) {
	  $hoursNoon = '12:00';
	  $hoursAfternoon = '14:00';
	  $hoursNight = '17:00';
			
		if ($hourIn >= $hoursNight) {
		  $turnHours = 'night';
		}

		elseif ($hourIn >= $hoursNoon) {
		  $turnHours = 'afternoon';
		}

		elseif ($hourOut > $hoursAfternoon) {
		  $turnHours = 'double';
		}

		else {
			$turnHours = 'morning';
		}

		return $turnHours;
	}

	public function permitExtendBetween($employee, $dateIn, $dateEnd) {
    $permitExtend = $employee
    									->permits()
    										->where('date_start', '<=', $dateEnd)
			                	->where('date_end','>=', $dateEnd)
												 ->where('state', '<>', 'cancelado')
			                	->orWhere(function($query) use ($dateIn, $dateEnd)  {
			              				$query->where('date_start', '>=', $dateIn)
			                		 				 ->where('date_end', '<=', $dateEnd)
												 						->where('state', '<>', 'cancelado');
			             			 })
			                	->orWhere(function($query) use ($dateIn, $dateEnd) {
			              				$query->where('date_start', '<', $dateIn)
			                						 ->where('date_end', '>=', $dateIn)
			                		  			 ->where('date_end', '<=', $dateEnd)
																	 ->where('state', '<>', 'cancelado');
			             			  });

		if ($permitExtend->count() > 0) {
	    $permitExtend = $permitExtend->first();
		  $permitIn = $permitExtend->date_start;
		  $permitEnd = $permitExtend->date_end;
			$message = 'Empleado con permiso desde '.$permitIn.' hasta '.$permitEnd. ' fechas no deben interferir con otro permisos';

			$this->hasException($message);
		}
     
    $this->permitRegularInExtend($employee, $dateIn, $dateEnd);

	}

	public function permitRegularInExtend($employee, $dateIn, $dateEnd) {
		$permitBetweenExtend = $employee
													 		->permits()
													 			->where('date_start','>=', $dateIn)
	 			             						->where('date_start','<=', $dateEnd)
												 				->where('state', '<>', 'cancelado');


		if ($permitBetweenExtend->count() > 0) {
		  $permitBetweenExtend = $permitBetweenExtend->first();
			$dateInit = $permitBetweenExtend->date_start;
			$message = 'Entre las fechas dadas hay un permiso el dia '.$dateInit;

			$this->hasException($message);
		}
	}

	public function permitExtendState(&$permit) {
		$date = current_date();
		$dateEnd = $permit->date_end;

		if ($dateEnd <= $date) {
			$permit->state = 'confirmado';

			$permit->save();
		}
	}



}