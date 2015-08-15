<?php

namespace Sams\Task;

use Sams\Repository\ScheduleRepository;
use Sams\Repository\PermitsRepository;

class PermitTask extends BaseTask {

	protected $scheduleRepository;
	protected $permitRepository;

	protected $months = ['01' => 'Enero',
	  									 '02' => 'Febrero',
	  									 '03' => 'Marzo',
	  									 '04' => 'Abril',
	  									 '05' => 'Mayo',
	  									 '06' => 'Junio',
	  									 '07' => 'Julio',
	  									 '08' => 'Agosto',
	  									 '09' => 'Septiembre',
	  									 '10' => 'Octubre',
	  									 '11' => 'Noviembre',
	  									 '12' => 'Diciembre'
	  				];

	public function __construct(ScheduleRepository $scheduleRepository, PermitsRepository $permitRepository)

	{
			$this->scheduleRepository = $scheduleRepository;
		  $this->permitRepository   = $permitRepository;
	}

	public function confirmedPermit($permit)

	{
			$segments     = explode('-', $permit->date_star);
			$firstDayMont = first_day_month($segments[1], date('Y'));
			$lastDayMont  = last_day_month($segments[1], date('Y'));
			$config       = get_configuration();
			$permitMonth  = $this->permitRepository->permissionsMonth($firstDayMont, $lastDayMont, $permit->employee_id);

			if ($permitMonth->count() == $config->max_permits)

			{
			 		$message = 'Empleado ya ha usado la cantidad maxima de '.$config->max_permits.' permisos por el mes de '.$this->months[$segments[1]];
			 		$this->hasException($message);
			}

			$this->permissonAccordingType($permit);
			 
	}

	public function permissonAccordingType($permit)

	{
			if ($permit->type == 'normal')

			{
					$this->confirmedDay($permit->date_star, $permit->employee_id, $permit->turn);		
					$schedules = $this->checkSchedule($permit->date_star, $permit->employee_id);
					
					$this->confirmSchedule($schedules, $permit);
					$this->permissRegularBetween($permit->employee_id, $permit->date_star);
			}

			else

			{
				  $this->permissExtend($permit->employee_id, $permit->date_star, $permit->date_end);
					$this->permissExtendBetween($permit->employee_id, $permit->date_star, $permit->date_end);
			}

	}

	public function confirmedDay($date, $idEmployee, $turn)

	{
			$permitDay = $this->permitRepository->getPermissionRegular($date, $idEmployee, $turn);

			if ($permitDay->count() > 0)

			{
				  $permitDay = $permitDay->first();
					$message   = 'Empleado ya tiene permiso para este  dia  y turno';
					$this->hasException($message);
			}

	}

	public function checkSchedule($date, $idEmployee)

	{
			$day = date_day($date);

			$schedules = $this->scheduleRepository->timesToday($day);

			if ($schedules->count() == 0)

			{
				  $message = 'Verifique fecha y turno';
					$this->hasException($message);
			}

			return $schedules->get();
	}

	public function confirmSchedule($schedules, $permit)

	{
		 	$count     = 0;
			$confirmed = false;
			$breakOut  = $permit->employee->breka_out;

			while ($count < count($schedules) && !$confirmed)

			{
					$schedule = $schedules[$count];
					$hasSchedule = $this->scheduleRepository->scheduleInEmployee($schedule->id, $permit->employee_id);
          
          if ($hasSchedule->count() > 0)

          {
          		if ($permit->turn == 'complete' || !$breakOut && $permit->turn != 'night')

          		{
          				$confirmed = true;
          		}

          		else

          		{
          				$turnHours = $this->confirmTurn($schedule->entry_time, $schedule->departure_time);

									if ($turnHours == $permit->turn || $permit->turn != 'night' && $turnHours == 'double')

									{
											$confirmed = true;
									}
          		}
          }
          $count++;
			}

			$message = 'Verifique fecha y turno';
			if (!$confirmed) $this->hasException($message);
	}

	public function confirmTurn($hourIn, $hourOut)

	{
			$hoursNoon      = '12:00';
			$hoursAfternoon = '14:00';
			$hoursNight     = '17:00';
			
			if ($hourIn >= $hoursNight)

			{
				 	$turnHours = 'night';
			}

			elseif ($hourIn >= $hoursNoon)

			{
					$turnHours = 'afternoon';
			}

			elseif ($hourOut > $hoursAfternoon)

			{
					$turnHours = 'double';
			}

			else

			{
					$turnHours = 'morning';
			}

			return $turnHours;

	}

	public function permissExtend($idEmployee, $starDay, $endDay)

	{
			$permitExtend = $this->permitRepository->getPermissionExtend($idEmployee, $starDay, $endDay);

			if ($permitExtend->count() > 0)

			{
					$permitExtend = $permitExtend->first();
					$message = 'Empleado con permiso desde '.$permitExtend->date_star.' hasta '.$permitExtend->date_end. ' ingrese fechas fuera del periodo';
					$this->hasException($message);
			}

	}

	public function permissExtendBetween($eId, $starDay, $endDay)

	{
			$permissBetween = $this->permitRepository->permissionBetweenExtend($eId, $starDay, $endDay);

			if ($permissBetween->count() > 0)

			{
					$permissBetween = $permissBetween->first();
					$message = 'Entre las fechas dadas se encuentra permiso para el '.$permissBetween->date_star;
					$this->hasException($message);
			}
	}

	public function permissRegularBetween($idEmployee, $date)

	{
			$permissBetween = $this->permitRepository->permissionsBetweenRegular($idEmployee, $date);

			if ($permissBetween->count() > 0)

			{
					$permissBetween = $permissBetween->first();
					$message = 'Empleado con permiso desde '.$permissBetween->date_star.' hasta '.$permissBetween->date_end. ' ingrese fecha fuera del periodo';
					$this->hasException($message);
			}
	}

	public function statePermissExtend(&$permissExtend)

	{
		  $day = current_date();
			if ($permissExtend->date_end <= $day)

			{
					$permissExtend->state = 0;
					$permissExtend->save();
			}
	}


}