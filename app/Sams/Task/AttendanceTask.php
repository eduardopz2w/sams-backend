<?php

namespace Sams\Task;

use Sams\Repository\AttendanceRepository;
use Sams\Repository\ScheduleRepository;
use Sams\Repository\PermitsRepository;

class AttendanceTask extends BaseTask {

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

	public function createAttendance($date)

	{
			$schedules  = $this->getSchedule($date);

			foreach ($schedules as $schedule) 
			
			{
					$employees = $schedule->employees;

					foreach ($employees as $employee) 

					{
						 $assingSchedule = $employee->pivot->created_at;
						
						 $employeeInDate = $this->entityInDate($assingSchedule, $date);

						 if ($employee->activiti && $employeeInDate)

						 {
								$this->checkSchedule($employee, $schedule, $date);
						 }
					}
			}
	}

	public function checkSchedule($employee, $schedule, $date)

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
					$this->registerAttendance($turnMorning, $employee->id, $hourIn, $hourMornigOut, $date);
					$this->registerAttendance($turnAfternoon, $employee->id, $hourAfternoonIn, $hourOut, $date);
			}

			else

			{
					$this->registerAttendance($scheduleTurn, $employee->id, $hourIn, $hourOut, $date);
			}
	}

	public function registerAttendance($turn, $idEmployee, $hourIn, $hourOut, $date)

	{

			 $attendance = $this->attendanceRepo->getModel();
			 $permit     = $this->hasPermit($idEmployee, $turn, $date);

			 $attendance->fill([
			 			'employee_id' 	 => $idEmployee,
			 			'turn'        	 => $turn,
			 			'state'       	 => 'I',
			 			'start_time'  	 => $hourIn,
			 			'departure_time' => $hourOut,
			 			'date_day'       => $date
			 	]);
			 

			 if ($permit)

			 {
			 		 $permit->attendances()->save($attendance);
			 }

			 $attendance->save();
	}

	public function entityInDate($assingSchedule, $date)

	{
			$segment    = explode(' ', $assingSchedule);
			$assingDate = $segment[0];

			if ($assingDate < $date)

			{
					return true;
			}

			return false;
	}


	public function getSchedule($date)

	{
			$day = $this->getDay($date);
			$schedules = $this->scheduleRepo->timesToday($day);

			$this->confimedAssists($schedules);

			return $schedules->get();
	}

	private function getDay($date)

	{
			return $day = date_day($date);
	}

	public function hasPermit($idEmployee, $turn, $date)

	{
			$permit = $this->permitRepo->getPermissionRegular($date, $idEmployee, $turn);

			if ($permit->count() > 0)

			{
					$response =  $permit->first();
			}

			else

			{
					$response = $this->hasPermitExtend($idEmployee, $date);
			}

			return $response;
	}

	public function hasPermitExtend($idEmployee, $date)

	{
			$permitExtend = $this->permitRepo->getPermitActivity($idEmployee, $date);
			$response     = false;
      
			if ($permitExtend->count() > 0)

			{
					$response = $permitExtend->first();
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

	public function confimedAssists($assists)

	{
			if ($assists->count() == 0)

			{
					$message = 'No hay asistencias para esta fecha';
					$this->hasException($message);
			}
	}

	public function confirmAttendancesTurn($sooner, $attendances)

	{
			if ($attendances->count() == 0 && !$sooner)

			{
					$message = 'No hay asistencias para este turno';
					$this->hasException($message);
			}

			else

			{
					$this->confimedAssists($attendances);
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


}