<?php

use Sams\Repository\AttendanceRepository;
use Sams\Task\AttendanceTask;

class AttendanceController extends BaseController {

	protected $attendanceRepo;
	protected $attendanceTask;

	public function __construct(AttendanceRepository $attendanceRepo, AttendanceTask $attendanceTask)

	{
			$this->attendanceRepo = $attendanceRepo;
			$this->attendanceTask = $attendanceTask;
	}

	public function attendance($sooner = null)

	{
		  $date = Input::get('date');

		  $this->attendanceTask->confirmDate($date);

		  $attendanceConfirm = $this->attendanceRepo->attendanceDayConfirm($date);	

			if ($attendanceConfirm->count() == 0)

			{
					$this->attendanceTask->createAttendance($date);
			}

			$attendances = $this->attendanceTask->getAttendance($date, $sooner);

			return Response::json(['status' => 'success',
				                     'data'   => $attendances]);
	}

}



