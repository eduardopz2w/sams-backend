<?php

namespace Sams\Repository;

use Sams\Entity\Employee;

class EmployeeRepository extends BaseRepository {

	public function getModel()

	{
			return new Employee;
	}

	public function getAttendances($date, $sooner, $turn)

	{
		  $join = Employee::join('attendances', 'employees.id','=','attendances.employee_id')
		  		            ->select(
		  		            	'employees.id',
		  		            	'employees.first_name',
		  		            	'employees.last_name',
		  		            	'attendances.start_time',
		  		              'attendances.departure_time',
		  		              'attendances.date_day'
		  		              );

		  if (!is_null($sooner))

		  {
		  		$attendances = $join->where('attendances.date_day', $date)
                       			  ->where('state', '<>', 'A')
			                 				->where('turn', $turn);
		  }

		  else

		  {
		  		$attendances = $join->where('attendances.date_day', $date)
                       			   ->where('state', '<>', 'A');
		  }

		  return $attendances;
		
	}

	public function employeeByIdentify($identify)

	{
			return Employee::where('identity_card', $identify);
	}

	public function employeeInSchedule($id, $hourIn, $hourOut, $days)

	{
			return Employee::with(

				['schedules' => function($q) use ($hourIn, $hourOut, $days) {
					
						$q->where('entry_time', '<=', $hourOut)
						  ->where('departure_time', '>=', $hourOut)
						  ->where('days', 'LIKE','%'.$days.'%')
						  ->orWhere(function($query) use ($hourIn, $hourOut, $days) {
						  		$query->where('entry_time', '>=', $hourIn)
						  		      ->where('departure_time', '<=', $hourOut)
						  		      ->where('days', 'LIKE','%'.$days.'%');
						  })
						  ->orWhere(function($query) use ($hourIn, $hourOut, $days) {
						  		$query->where('entry_time', '<', $hourIn)
						  		      ->where('departure_time', '>=', $hourIn)
						  		      ->where('departure_time', '<=', $hourOut)
						  		      ->where('days', 'LIKE','%'.$days.'%');
						  });

				}])->where('id', $id)->get();
	}

	public function employeeInScheduleDay($id, $days)

	{
			return Employee::with(

				['schedules' => function ($q) use ($days) {

					 $q->where('days', 'LIKE', '%'.$days.'%');

				}])->where('id', $id)->get();
	}


}
