<?php

namespace Sams\Repository;

use Sams\Entity\Attendance;

class AttendanceRepository extends BaseRepository {


	public function getModel() {
		return new Attendance;
	}
	
	public function attendanceForDay($date) {
		return Attendance::where('date_day', $date);
	}

	public function attendanceToday($date, $hour) {
		return Attendance::join('employees', 'attendances.employee_id', '=', 'employees.id')
										 ->select(
		  		            	'employees.identity_card',
		  		            	'employees.first_name',
		  		            	'employees.last_name',
		  		            	'attendances.start_time',
		  		             	'attendances.date_day',
		  		             	'attendances.employee_id',
		  		             	'attendances.id'
		  		             )
											 ->where('attendances.date_day', $date)
                       ->where('state', 'I')
                       ->where('departure_time', '<=', $hour)
                       ->whereNull('permit_id');

	}

	public function attendanceForDate($date) {
		return Attendance::join('employees', 'attendances.employee_id', '=', 'employees.id')
										 ->select(
										 		'employees.identity_card',
		  		            	'employees.first_name',
		  		            	'employees.last_name',
		  		            	'attendances.start_time',
		  		            	'attendances.departure_time',
		  		              'attendances.hour_in',
		  		              'attendances.hour_out',
		  		             	'attendances.state',
		  		             	'attendances.employee_id',
		  		             	'attendances.id'
		  		            )
										  ->where('attendances.date_day', $date)
										  ->whereNull('permit_id');
	}

	public function attendanceWaiting ($date) {
	  return Attendance::join('employees', 'attendances.employee_id', '=', 'employees.id')
										  ->select(
		  		             	 'employees.identity_card',
		  		            	 'employees.first_name',
		  		            	 'employees.last_name',
		  		             	 'attendances.departure_time',
		  		               'attendances.date_day',
		  		               'attendances.employee_id',
		  		               'attendances.id'
		  		              )
										  ->where('attendances.date_day', $date)
										  ->where('state', 'E');
	}


}