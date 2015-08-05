<?php

namespace Sams\Repository;

use Sams\Entity\Attendance;

class AttendanceRepository extends BaseRepository {

	public function getModel()

	{
		 return new Attendance;
	}


	public function attendanceDay($date)

	{
			return Attendance::where('created_at', 'LIKE', '%'.$date.'%');

	}


}