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
		  if (!$sooner)

		  {
		  		$attendances = Employee::join('attendances', 'employees.id','=','attendances.employee_id')
		  		                        ->select(
		  		                        		'employees.id',
		  		                        		'employees.first_name',
		  		                        		'employees.last_name',
		  		                        		'attendances.start_time',
		  		                        		'attendances.departure_time'
		  		                        	)
                       						->where('attendances.created_at', 'LIKE', '%'.$date.'%')
                       						->where('state', '<>', 'A')
			                 						->where('turn', $turn);
		  }

		  else

		  {
		  		$attendances = Employee::join('attendances', 'employees.id', '=','attendances.employee_id')
		  													 ->select(
		  		                        		'employees.id',
		  		                        		'employees.first_name',
		  		                        		'employees.last_name',
		  		                        		'attendances.start_time',
		  		                        		'attendances.departure_time'
		  		                        	)
                       					 ->where('attendances.created_at', 'LIKE', '%'.$date.'%')
                       					 ->where('state', '<>', 'A');
		  }

		  return $attendances;
		
	}

}
