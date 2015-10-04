<?php

use Sams\Manager\AttendanceManager;
use Sams\Repository\AttendanceRepository;
use Sams\Repository\EmployeeRepository;
use Sams\Task\AttendanceTask;
use Sams\Task\AssistanceTask;
	
class AttendanceController extends BaseController {

	protected $employeeRepo;
	protected $attendanceRepo;
	protected $attendanceTask;
	protected $assistanceTask;

	public function __construct(AttendanceRepository $attendanceRepo, 
		                          EmployeeRepository $employeeRepo,
			                        AttendanceTask $attendanceTask,
			                        AssistanceTask $assistanceTask) {
		$this->employeeRepo   = $employeeRepo;
		$this->attendanceRepo = $attendanceRepo;
		$this->attendanceTask = $attendanceTask;
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

	public function attendancesWaiting() {
		$date = Input::get('date');

		$response = $this->attendanceTask->getAttendanceWaiting($date);

		return Response::json($response);
	}

	public function edit($employeeId, $attendanceId) {
		$attendance = $this->attendanceRepo->find($attendanceId);
		$employee = $attendance->employee;
		$employeeState = $employee->activiti;

		$this->assistanceTask->statusEmployee($employeeState);

		$employeeId = $employee->id;
		$data = Input::except('_method');
		$manager = new AttendanceManager($attendance, $data);
	

		$manager->isValid();
		$this->assistanceTask->checkAssistance($data, $employee, $attendance);
		$manager->edit();

		$response = [
			'status' => 'success',
			'message' => 'Asistencia actualizada',
		  'data' => $attendance,
		];

		return Response::json($response);
	}

	public function confirmed($employeeId, $attendanceId) {
		$attendance = $this->attendanceRepo->find($attendanceId);
		$state = Input::get('state');
    $response = $this->assistanceTask->confirmedAssitance($attendance, $state);
		
		return Response::json($response);
	}

	public function assistanceForEmployee($employeeId) {
		$employee = $this->employeeRepo->find($employeeId);
		$attendances = $this->assistanceTask->getAssistanceForEmploye($employee);
		$response = [
			'status' => 'success',
			'data' => $attendances
		];

		return Response::json($response);
	}


}



