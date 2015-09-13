<?php

namespace Sams\Task;

use Sams\Repository\PermitRepository;
use Sams\Repository\EmployeeRepository;

class PermitTask extends BaseTask {

	protected $permitRepo;
	protected $employeeRepo;

	public function __construct(EmployeeRepository $employeeRepo,
		                          PermitRepository $permitRepo) {
		$this->employeeRepo = $employeeRepo;
	  $this->permitRepo   = $permitRepo;
	}

	public function confirmDate($permit) {
		$type = $permit->type;
		$dateInit = $permit->date_star;
		$dateEnd = $permit->date_end;
		
		if ($type == 'extend') {
			if ($dateInit >= $dateEnd) {
				$message = 'Ingrese fechas correctamente';

	  		$this->hasException($message);
			}
		}
	}

	public function confirmedPermit($permit) {
		$this->confirmDate($permit);

		$segments = explode('-', $permit->date_star);
	  $firstDayMont = first_day_month($segments[1], date('Y'));
	  $lastDayMont = last_day_month($segments[1], date('Y'));
	  $config = get_configuration();
	  $month = \Lang::get('utils.months_number.'.$segments[1]);
	  $maxPermit = $config->max_permits;
	  $idEmployee = $permit->employee_id;
	  $permitMonth = $this->permitRepo->permitMonth($firstDayMont, $lastDayMont, $idEmployee);

	  if ($permitMonth->count() == $maxPermit) {
		  $message = 'Empleado ha usado la cantidad maxima de '.$maxPermit.' permisos por el mes de '.$month;

		  $this->hasException($message);
	  }

		$this->permissonAccordingType($permit);

	}

	public function permissonAccordingType($permit) {
		$dateInit = $permit->date_star;
	  $dateEnd = $permit->date_end;
		$idEmployee = $permit->employee_id;
		$turn = $permit->turn;
		$type = $permit->type;

		if ($type == 'normal') {
		  $this->confirmDay($permit);	
		} else {
		  $this->permitExtendBetween($permit);
		}
	}

	public function confirmDay($permit) {
		$id = $permit->employee_id;
	  $date = $permit->date_star;
	  $turn = $permit->turn;
		$permitDay = $this->permitRepo->getPermitRegular($id, $date, $turn);

		if ($permitDay->count() > 0) {
			$permitDay = $permitDay->first();
		  $message = 'Empleado ya tiene permiso para esta fecha y turno';

		  $this->hasException($message);
		}

		$this->permitRegularBetween($permit);
		$this->checkSchedule($permit);
	}

	public function permitRegularBetween($permit) {
	  $id = $permit->employee_id;
	  $date = $permit->date_star;
		$permitRegBetween = $this->permitRepo->permitRegularIsBetween($id, $date);

		if ($permitRegBetween->count() > 0) {
			$permitRegBetween = $permitRegBetween->first();
		  $dateInt = $permitRegBetween->date_star;
		  $dateEnd = $permitRegBetween->date_end;
		  $message = 'Empleado con permiso desde '.$dateInt.' hasta '.$dateEnd. ' ingrese dia fuera del periodo';

			$this->hasException($message);
		}
	}

	public function checkSchedule($permit) {
	  $id = $permit->employee_id;
	  $date = $permit->date_star;
    $day = date_day($date);
    $turn = $permit->turn;
    $employee = $this->employeeRepo->employeeInScheduleDay($id, $day);
    $message = 'Verifique fecha y turno';

		foreach ($employee as $e) {
		  $schedules = $e->schedules;

			if (count($schedules) == 0) {
				$this->hasException($message);
			}

			break;
		}
    
		if ($turn != 'complete') {
    	$this->confirmSchedule($schedules, $permit, $message);
		}
			
	}

	public function confirmSchedule($schedules, $permit, $message) {
	  $turn = $permit->turn;
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

	public function permitExtendBetween($permit) {
	  $id = $permit->employee_id;
	  $dateInit = $permit->date_star;
	  $dateEnd = $permit->date_end;
    $permitExtend = $this->permitRepo->permitExtendIsBetween($id, $dateInit, $dateEnd);

		if ($permitExtend->count() > 0) {
	    $permitExtend = $permitExtend->first();
		  $dateInit = $permitExtend->date_star;
		  $dateEnd = $permitExtend->date_end;
			$message = 'Empleado con permiso desde '.$dateInit.' hasta '.$dateEnd. ' fechas no deben interferir con otro permisos';

			$this->hasException($message);
		}
     
    $this->permitRegularInExtend($permit);

	}

	public function permitRegularInExtend($permit) {
		$id = $permit->employee_id;
		$dateInit = $permit->date_star;
		$dateEnd = $permit->date_end;
		$permitBetweenExtend = $this->permitRepo->permitRegularInExtend($id, $dateInit, $dateEnd);

		if ($permitBetweenExtend->count() > 0) {
		  $permitBetweenExtend = $permitBetweenExtend->first();
			$dateInit = $permitBetweenExtend->date_star;
			$message = 'Entre las fechas dadas hay un permiso el dia '.$dateInit;

			$this->hasException($message);
		}
	}


		

	// public function statePermissExtend(&$permissExtend)

	// {
	// 	  $day = current_date();

	// 		if ($permissExtend->date_end <= $day)

	// 		{
	// 				$permissExtend->state = 0;
	// 				$permissExtend->save();
	// 		}
	// }


}