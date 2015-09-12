<?php

namespace Sams\Task;

use Sams\Repository\AttendanceRepository;
use Sams\Repository\ScheduleRepository;
use Sams\Repository\PermitRepository;

class AttendanceTask extends BaseTask {

	protected $attendanceRepo;
	protected $scheduleRepo;
	protected $permitRepo;
	protected $permitTask;

	public function __construct(AttendanceRepository $attendanceRepo, 
		                          ScheduleRepository $scheduleRepo,
		                          PermitRepository $permitRepo, 
		                          PermitTask $permitTask) {
		$this->attendanceRepo = $attendanceRepo;
	  $this->scheduleRepo   = $scheduleRepo;
	  $this->permitRepo     = $permitRepo;
	  $this->permitTask     = $permitTask;
	}
	 
	public function confirmDate($date) {
		$regex = '/\d{4}\-\d{2}-\d{2}/';

		if (!preg_match($regex, $date)) {
			$message = 'Formato de fecha es inválido';

    	$this->hasException($message);
    }

  	$currentDate = current_date();

  	if ($date > $currentDate) {
  		$message = 'Fecha no ha pasado';

  		$this->hasException($message);
  	}
	}
	 
	public function createAttendance($date) {
	  $schedules = $this->getSchedule($date);

	  foreach ($schedules as $schedule) {
	  	$employees = $schedule->employees;

			foreach ($employees as $employee) {
				$assingSchedule = $employee->pivot->created_at;		
				$employeeInDate = $this->entityInDate($assingSchedule, $date);

				if ($employee->activiti && $employeeInDate) {
					$this->checkSchedule($employee, $schedule, $date);
				}
			}
	  }
	}

	public function getSchedule($date) {
		$day = date_day($date);
	  $schedules = $this->scheduleRepo->scheduleInEmployeeDay($day);

    $this->confirmAttendance($schedules);

    $schedules = $schedules->get();

	  return $schedules;
	}

	public function entityInDate($assingSchedule, $date) {
		$segment = explode(' ', $assingSchedule);
	  $assingDate = $segment[0];

	  if ($assingDate < $date) {
		  return true;
		}

		return false;
	}

	public function checkSchedule($employee, $schedule, $date) {
		$employeeId = $employee->id;
	  $hourIn = $schedule->entry_time;
    $hourOut = $schedule->departure_time;
    $turn = $this->permitTask->confirmTurn($hourIn, $hourOut);
    $morning = 'morning';
    $afternoon = 'afternoon';
    $morningOut = '12:00';
    $afternoonIn = '14:00';

		if ($turn == 'double' && $employee->break_out) {
			$this->register($morning, $employeeId, $hourIn, $morningOut, $date);
		  $this->register($afternoon,$employeeId, $afternoonIn, $hourOut, $date);
		} else {
			$this->register($turn, $employeeId, $hourIn, $hourOut, $date);
		}

	}

	public function register($turn, $employeeId, $hourIn, $hourOut, $date) {
		$attendance = $this->attendanceRepo->getModel();
	  $permit = $this->hasPermit($employeeId, $turn, $date);

		$attendance->fill([
			'employee_id' => $employeeId,
		  'turn' => $turn,
		  'state' => 'I',
		  'start_time' => $hourIn,
		  'departure_time' => $hourOut,
		  'date_day' => $date
		]);
			 
		if ($permit) {
			$permit->attendances()->save($attendance);
		}

		$attendance->save();
	}
	  
	public function hasPermit($employeeId, $turn, $date) {
		$permit = $this->permitRepo->getPermitRegular($date, $employeeId, $turn);

		if ($permit->count() > 0) {
			$response = $permit->first();
		} else {
		  $response = $this->hasPermitExtend($employeeId, $date);
		}

		return $response;
	}

	public function hasPermitExtend($employeeId, $date) {
		$permitExtend = $this->permitRepo->permitExtendActive($employeeId, $date);
		$response = false;

		if ($permitExtend->count() > 0) {
			$response = $permitExtend->first();
		}

		return $response;
	}

	public function getAttendance($date, $sooner) {
	 	if (!$sooner) {
	 		$hour = $this->getHour();
	 		$attendance = $this->attendanceRepo->attendanceToday($date, $hour);

	 		if ($attendance->count() == 0) {
	 			$message = 'No hay asistencias por confirmar en este momento';

	 			$this->hasException($message);
	 		}

	 		$attendance = $attendance->get();
	 	} else {
	 		$attendance = $this->getAttendanceForDate($date);
	 	}

	 	return $attendance;
	}
  
  public function getAttendanceForDate($date) {
  	$attendance = $this->attendanceRepo->attendanceForDate($date);

  	$this->confirmAttendance($attendance);

  	$attendance = $attendance->get();

  	return $attendance;
  }

  public function getAttendanceWaiting($date) {
  	$attendance = $this->attendanceRepo->attendanceWaiting($date);

  	if ($attendance->count() == 0) {
  		$message = 'No hay asistencias con salidas por confirmar';

  		$this->hasException($message);
  	}

  	$attendance = $attendance->get();
    $response = [
      'status' => 'success',
      'data' => $attendance
    ];

  	return $response;
  }

	public function confirmAttendance($attendance) {
	  if ($attendance->count() == 0) {
		  $message = 'No hay asistencias por confirmar para esta fecha';

		  $this->hasException($message);
	  }
	}

	public function getHour() {
		$hour = current_hour();
	  $hourAfternoon = '17:00';
	  $hourNoon  = '12:00';

		if ($hour > $hourAfternoon) {
		  $hourTurn = $hour;
		} elseif ($hour > $hourNoon) {
		  $hourTurn = $hourAfternoon;
		} else {
		  $hourTurn = $hourNoon;
		}

    return $hourTurn;
	}

}