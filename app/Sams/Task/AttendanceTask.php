<?php

namespace Sams\Task;

use Sams\Repository\AttendanceRepository;
use Sams\Repository\ScheduleRepository;

class AttendanceTask extends BaseTask {

	protected $attendanceRepo;
	protected $scheduleRepo;
	protected $permitTask;

	public function __construct(AttendanceRepository $attendanceRepo, 
		                          ScheduleRepository $scheduleRepo, 
		                          PermitTask $permitTask) {
		$this->attendanceRepo = $attendanceRepo;
	  $this->scheduleRepo   = $scheduleRepo;
	  $this->permitTask     = $permitTask;
	}
	 
	public function confirmDate($date) {
	  $date = ['date' => $date];
    $rules = ['date' => 'required|date'];
    $messages = [
      'date.required' => 'Ingrese fecha',
      'date.date' => 'Ingrese formato de fecha valido'
    ];
    $validator = \Validator::make($date, $rules, $messages);

    if ($validator->fails()) {
      $message = $validator->messages();

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

	  if ($assingDate <= $date) {
  
		  return true;
		} else {
      return false;
    }

	}

	public function checkSchedule($employee, $schedule, $date) {
	  $hourIn = $schedule->entry_time;
    $hourOut = $schedule->departure_time;
    $turn = $this->permitTask->confirmTurn($hourIn, $hourOut);
    $morning = 'morning';
    $afternoon = 'afternoon';
    $morningOut = '12:00';
    $afternoonIn = '14:00';

		if ($turn == 'double' && $employee->break_out) {
			$this->register($morning, $employee, $hourIn, $morningOut, $date);
		  $this->register($afternoon,$employee, $afternoonIn, $hourOut, $date);
		} else {
			$this->register($turn, $employee, $hourIn, $hourOut, $date);
		}

	}

	public function register($turn, $employee, $hourIn, $hourOut, $date) {
		$attendance = $this->attendanceRepo->getModel();
	  $permit = $this->hasPermit($employee, $date);
    $data = [
      'turn' => $turn,
      'state' => 'I',
      'start_time' => $hourIn,
      'departure_time' => $hourOut,
      'date_day' => $date
    ];

		$attendance->fill($data);
    $employee->attendances()->save($attendance);
			 
		if ($permit) {
			$permit->attendances()->save($attendance);
		}

		$attendance->save();
	}
	  
	public function hasPermit($employee, $date) {
    $permit = $employee
                ->permits()
                  ->where('date_start', $date)
                  ->where('state', 'espera')
                  ->where('type', 'normal');

    if ($permit->count() > 0) {
      $permit = $permit->first();
      $permit->state = 'confirmado';

      $permit->save();

      return $permit;
    } else {
      $permit = $employee
                  ->permits()
                   ->where('state', 'espera')
                   ->where('date_start', '<=', $date)
                   ->where('date_end', '>=', $date);

      if ($permit->count() > 0) {
        $permit = $permit->first();

        $this->permitTask->permitExtendState($permit);

        return $permit;
      }
    }
		
    return false;
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