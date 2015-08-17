<?php

use Sams\Repository\AttendanceRepository;
use Sams\Repository\EmployeeRepository;
use Sams\Task\AttendanceTask;

class AttendanceController extends BaseController {

	protected $attendanceRepo;
	protected $employeeRepo;
	protected $attendanceTask;

	public function __construct(AttendanceRepository $attendanceRepo, AttendanceTask $attendanceTask, 
		                          EmployeeRepository $employeeRepo)

	{
			$this->attendanceRepo = $attendanceRepo;
			$this->employeeRepo   = $employeeRepo;
			$this->attendanceTask = $attendanceTask;
	}

	public function attendance($sooner = null)

	{
		  $date = Input::get('date');

		  $this->attendanceTask->confirmDate($date);
		  
			$attendances = $this->attendanceRepo->attendanceDay($date);
			$turn = $this->attendanceTask->getTurn();
	
			if ($attendances->count() == 0)

			{
					$this->attendanceTask->createAttendance($date);
			}

			$attendances = $this->employeeRepo->getAttendances($date, $sooner, $turn);		
			$this->attendanceTask->confirmAttendancesTurn($sooner, $attendances);

			return Response::json(['status' => 'success',
				                     'data'   => $attendances->get()]);
	}

}