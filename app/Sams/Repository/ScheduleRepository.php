<?php

namespace Sams\Repository;

use Sams\Entity\Schedule;

class ScheduleRepository extends BaseRepository {


	public function getModel() {
	  return new Schedule;
	}
	
	public function getScheduleforData($hourIn, $hourOut, $days) {
	  return Schedule::where('entry_time', $hourIn)
			     	->where('departure_time', $hourOut)
			     	->where('days', $days);
	}
	
	public function scheduleInEmployee($scheduleId, $employeeId) {
	  return \DB::table('employee_schedule')
			      	->where('schedule_id', $scheduleId)
					 	  ->where('employee_id', $employeeId);
	}
	
	public function scheduleBetweenDifferences($star, $end) {
	  return Schedule::where('departure_time', '>=', $star)
			     	->where('departure_time', '<', $end)
			     	->orderBy('departure_time', 'DESC');
	}

	public function scheduleInEmployeeDay($day) {
		return Schedule::with(['employees'])
			      ->where('days', 'LIKE', '%'.$day.'%');
	}
	
	public function scheduleInActionDay($day) {
		return Schedule::with(['actions'])
		      	->where('days', 'Like', '%'.$day.'%');
	}

	// public function scheduleInAction($idH, $idA)

	// {
	// 		return \DB::table('action_schedule')
	// 		          ->where('schedule_id', $idH)
	// 		          ->where('action_id', $idA);
	// }

	// public function timesToday($day)

	// {
	// 		return Schedule::where('days', 'LIKE', '%'.$day.'%');
	// }

	// public function intervalSchedule($star, $end)

	// {
	// 		return Schedule::where('entry_time', '<=', $end)
	// 		                ->where('departure_time','>=', $end)
	// 		                ->orWhere(function($q) use ($star, $end)  {
	// 		                		$q->where('entry_time', '>=', $star)
	// 		                		  ->where('departure_time', '<=', $end);
	// 		                })
	// 		                ->orWhere(function($q) use ($star, $end) {
	// 		                		$q->where('entry_time', '<', $star)
	// 		                		  ->where('departure_time', '>=', $star)
	// 		                		  ->where('departure_time', '<=', $end);
	// 		                });
			               
	// }



}