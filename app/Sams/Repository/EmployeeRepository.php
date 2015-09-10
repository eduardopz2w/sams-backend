<?php

namespace Sams\Repository;

use Sams\Entity\Employee;

class EmployeeRepository extends BaseRepository {

	public function getModel()

	{
	  return new Employee;
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

	public function createEmployee()

	{
	  $employee = new Employee();
	  
	  $employee->image_url = 'http://localhost/image/geriatric/default/profile_default_man.png';
	  $employee->mime = 'jpg';	
	  
	  return $employee;
	}


}
