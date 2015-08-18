<?php

namespace Sams\Repository;

use Sams\Entity\Attendance;

class AttendanceRepository extends BaseRepository {

	public function getModel()

	{
		 return new Attendance;
	}


	public function attendanceDayConfirm($date)

	{
			return Attendance::where('created_at', 'LIKE', '%'.$date.'%');

	}

	public function attendanceDay($date, $sooner, $hour)

	{
			$join = Attendance::join('employees', 'attendances.employee_id', '=', 'employees.id')
												->select(
		  		            		'employees.id',
		  		            		'employees.first_name',
		  		            		'employees.last_name',
		  		            		'attendances.start_time',
		  		              	'attendances.departure_time',
		  		              	'attendances.date_day'
		  		              );

		  if (is_null($sooner))

		  {
		  		$attendances = $join->where('attendances.date_day', $date)
                       			  ->where('state', '<>', 'A')
                       			  ->where('departure_time', '<=', $hour);
		  }

		  else

		  {
		  		$attendances = $join->where('attendances.date_day', $date)
                       			  ->where('state', '<>', 'A');
			                 				
		  }

		  return $attendances;
	}


}