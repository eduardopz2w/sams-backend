<?php

namespace Sams\Task;

use Sams\Repository\AttendanceRepository;
use Sams\Repository\ScheduleRepository;
use Sams\Repository\PermitsRepository;
use Sams\Manager\ValidationException;

class AttendanceTask {

	protected $attendanceRepo;
	protected $scheduleRepo;
	protected $permitRepo;
	protected $permitTask;

	public function __construct(AttendanceRepository $attendanceRepo, ScheduleRepository $scheduleRepo,
		                          PermitsRepository $permitRepo, PermitTask $permitTask)

	{
			$this->attendanceRepo = $attendanceRepo;
			$this->scheduleRepo   = $scheduleRepo;
			$this->permitRepo     = $permitRepo;
			$this->permitTask     = $permitTask;
	}

	public function createAttendance()

	{
			$schedules  = $this->getSchedule();

			foreach ($schedules as $schedule) 
			
			{
					$employees = $schedule->employees;

					foreach ($employees as $employee) 

					{
						 if ($employee->activiti)

						 {
								$this->checkSchedule($employee, $schedule);
						 }
					}
			}
	}

	public function checkSchedule($employee, $schedule)

	{
			$scheduleTurn    = $this->permitTask->confirmTurn($schedule->entry_time, $schedule->departure_time);
			$turnMorning     = 'morning';
			$turnAfternoon   = 'afternoon';
			$hourIn          =  $schedule->entry_time;
			$hourOut         =  $schedule->departure_time;
			$hourMornigOut   = '12:00';
			$hourAfternoonIn = '14:00';

			if ($scheduleTurn == 'double' && $employee->break_out)

			{
					$this->registerAttendance($turnMorning, $employee->id, $hourIn, $hourMornigOut);
					$this->registerAttendance($turnAfternoon, $employee->id, $hourAfternoonIn, $hourOut);
			}

			else

			{
					$this->registerAttendance($scheduleTurn, $employee->id, $hourIn, $hourOut);
			}
	}

	public function registerAttendance($turn, $idEmployee, $hourIn, $hourOut)

	{

			 $attendance = $this->attendanceRepo->getModel();
			 $permit     = $this->hasPermit($idEmployee, $turn);
			 
			 $attendance->employee_id    = $idEmployee;
			 $attendance->turn           = $turn;
			 $attendance->state          = 'I';
			 $attendance->start_time     = $hourIn;
			 $attendance->departure_time = $hourOut;

			 if ($permit)

			 {
			 		 $permit->attendances()->save($attendance);
			 }

			 $attendance->save();
	}


	public function getSchedule()

	{
			$day = $this->getDay();
			$schedules = $this->scheduleRepo->timesToday($day);

			if ($schedules->count() == 0)

			{
					$message = 'No hay asistencias para esta fecha';
					$this->hasException($message);
			}

			return $schedules->get();
	}

	private function getDay()

	{
			$date = current_date();
			$day  = date_day($date);

		 	return $day;
	}

	public function hasPermit($idEmployee, $turn)

	{
		  $date = current_date();
		  // $turn = $this->convertTurn($turn);

			$permit = $this->permitRepo->getPermissionRegular($date, $idEmployee, $turn);

			if ($permit->count() > 0)

			{
					$response =  $permit->first();
			}

			else

			{
					$response = $this->hasPermitExtend($idEmployee);
			}

			return $response;
	}

	public function hasPermitExtend($idEmployee)

	{
			$permitExtend = $this->permitRepo->getPermissionExtend($idEmployee);
			$date     = current_date();
			$response = false;
      
			if ($permitExtend->count() > 0)

			{
					$permitExtend = $permitExtend->first();

					if ($permitExtend->date_star <= $date && $permitExtend->date_end >= $date)

					{
							$response =  $permitExtend;
					}

					$this->permitTask->statePermissExtend($permitExtend);
			}

			return $response;
	}

	public function getTurn()

	{
		  $hour    = date('H:i');
			$hourOut = null;
			$turn    = $this->permitTask->confirmTurn($hour, $hourOut);

			return $turn;
	}

	public function confirmAttendancesTurn($sooner, $attendances)

	{
			if ($attendances->count() == 0 && !$sooner)

			{
					$message = 'No hay asistencias para este turno';
					$this->hasException($message);
			}
	}

	public function confirmDate($date)

	{
			$dateCurrent = current_date();

			if ($date > $dateCurrent)

			{
					$message = 'fecha no ha pasado';
					$this->hasException($message);
			}
	}


	public function hasException($message)

	{
			throw new ValidationException("Error Processing Request", $message);
	}

}