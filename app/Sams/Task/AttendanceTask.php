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

	public function confirmDate($date)

	{
		  $dateCurrent = current_date();
		  $dateBefore  = add_date('1', $dateCurrent);

		  $date  = ['date' => $date];
		  $rules = ['date' => 'date|before:'.$dateBefore];

		  $validator = \Validator::make($date, $rules);

		  if ($validator->fails()) $this->hasException($validator->messages());
	}


	public function createAttendance($date)

	{
			$schedules = $this->getSchedule($date);

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

	public function getSchedule($date)

	{
		  $day       = date_day($date);
		  $schedules = $this->scheduleRepo->scheduleInEmployeeDay($day);
      $this->confirmAttendance($schedules);

      $schedules = $schedules->get();
		  return $schedules;
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

	public function checkSchedule($employee, $schedule, $date)

	{
		  $id              = $employee->id;
		  $hourIn          = $schedule->entry_time;
			$hourOut         = $schedule->departure_time;
			$scheduleTurn    = $this->permitTask->confirmTurn($hourIn, $hourOut);
			$turnMorning     = 'morning';
			$turnAfternoon   = 'afternoon';
			$hourMornigOut   = '12:00';
			$hourAfternoonIn = '14:00';

			if ($scheduleTurn == 'double' && $employee->break_out)

			{
					$this->registerAttendance($turnMorning, $id, $hourIn, $hourMornigOut, $date);
					$this->registerAttendance($turnAfternoon, $id, $hourAfternoonIn, $hourOut, $date);
			}

			else

			{
					$this->registerAttendance($scheduleTurn, $id, $hourIn, $hourOut, $date);
			}
	}

	public function registerAttendance($turn, $idEmployee, $hourIn, $hourOut, $date)

	{
			 $attendance = $this->attendanceRepo->getModel();
			 $permit     = $this->hasPermit($idEmployee, $turn, $date);

			 $attendance->fill([
			 	 'employee_id' 	  => $idEmployee,
			 	 'turn'        	  => $turn,
			 	 'state'       	  => 'I',
			 	 'start_time'  	  => $hourIn,
			 	 'departure_time' => $hourOut,
			 	 'date_day'       => $date
			 	]);
			 
			 if ($permit)

			 {
			 		 $permit->attendances()->save($attendance);
			 }

			 $attendance->save();
	}


	public function hasPermit($idEmployee, $turn, $date)

	{
			$permit = $this->permitRepo->getPermitRegular($date, $idEmployee, $turn);

			if ($permit->count() > 0)

			{
					$response = $permit->first();
			}

			else

			{
					$response = $this->hasPermitExtend($idEmployee, $date);
			}

			return $response;
	}

	public function hasPermitExtend($idEmployee, $date)

	{
			$permitExtend = $this->permitRepo->permitExtendActive($idEmployee, $date);
			$response     = false;
      
			if ($permitExtend->count() > 0)

			{
					$response = $permitExtend->first();
			}

			return $response;
	}


	public function getAttendance($date, $sooner)

	{
		 $hour = $this->getHour();

		 $attendance = $this->attendanceRepo->attendanceDay($date, $sooner, $hour);

		  if ($sooner)

		  {
		  	  $this->confirmAttendance($attendance);
		  }

		  elseif ($attendance->count() == 0)

		  {
		  		$message = 'No hay asistencias para este turno';
		  		$this->hasException($message);
		  }

		  $attendance = $attendance->get();
		  return $attendance;
	}

	public function confirmAttendance($attendance)

	{
			if ($attendance->count() == 0)

			{
					$message = 'No hay asistencias para esta fecha';
					$this->hasException($message);
			}
	}


	public function getHour()

	{
			$hour      = date('H:i');
			$hourNight = '17:00';
			$hourNoon  = '12:00';

			if ($hour > $hourNight)

			{
					$hourTurn = $hour;
			}

			elseif ($hour > $hourNoon)

			{
					$hourTurn = $hourNight;
			}

			else

			{
					$hourTurn = $hourNoon;
			}
      
      return $hourTurn;
	}

}