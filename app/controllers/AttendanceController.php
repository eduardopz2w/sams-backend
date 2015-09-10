<?php

use Sams\Manager\AttendanceManager;
use Sams\Repository\AttendanceRepository;
use Sams\Task\AttendanceTask;
use Sams\Task\AssistanceTask;
	
class AttendanceController extends BaseController {

	protected $attendanceRepo;
	protected $attendanceTask;
	protected $assistanceTask;

	public function __construct(AttendanceRepository $attendanceRepo, 
			                        AttendanceTask $attendanceTask,
			                        AssistanceTask $assistanceTask) {
		$this->attendanceRepo  = $attendanceRepo;
		$this->attendanceTask  = $attendanceTask;
		$this->assistanceTask = $assistanceTask;
	}

	public function attendances() {
  	$date = Input::get('date');
  	$sooner = Input::get('sooner');
  
		$this->attendanceTask->confirmDate($date);

		$attendanceDay = $this->attendanceRepo->attendanceForDay($date);	

		if ($attendanceDay->count() == 0) {
			$this->attendanceTask->createAttendance($date);
		}

		$attendances = $this->attendanceTask->getAttendance($date, $sooner);
		$response = [
			'status' => 'success',
			'data' => $attendances
		];

		return Response::json($response);
	}

	public function confirmed($id) {
		$attendance = $this->attendanceRepo->find($id);
		$state = Input::get('state');
    $response = $this->assistanceTask->confirmedAssitance($attendance, $state);
		
		return Response::json($response);
	}

	public function attendanceWaiting() {
		$date = Input::get('date');

		$response = $this->attendanceTask->getAttendanceWaiting($date);

		return Response::json($response);
	}

	public function edit($id) {
		$attendance = $this->attendanceRepo->find($id);
		$employee = $attendance->employee;
		$employeeState = $employee->activiti;

		$this->assistanceTask->statusEmployee($employeeState);

		$employeeId = $employee->id;
		$data = Input::except('_method');
		$manager = new AttendanceManager($attendance, $data);
		$scheduleIn = $attendance->start_time;
		$scheduleOut = $attendance->departure_time;
		$turn = $attendance->turn;

		$manager->isValid();
		$this->assistanceTask->checkAssistance($data, $scheduleIn, $scheduleOut, $employeeId, $turn);
		$manager->save();

		$response = [
			'status' => 'success',
			'message' => 'Horario actualizado',
		  'data' => $attendance,
		];

		return Response::json($response);
	}

			

}



