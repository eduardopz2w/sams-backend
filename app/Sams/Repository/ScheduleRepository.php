<?php

namespace Sams\Repository;

use Sams\Entity\Schedule;

class ScheduleRepository extends BaseRepository {


	public function getModel()

	{
			return new Schedule;
	}

	public function getScheduleforData($hourIn, $hourOut, $days)

	{
			return Schedule::where('entry_time', $hourIn)
			          ->where('departure_time', $hourOut)
			          ->where('days', $days);
	}

	// public function scheduleInEmployee($idH, $idEm)

	// {
	// 		return \DB::table('employee_schedule')
	// 		          ->where('schedule_id', $idH)
	// 							->where('employee_id', $idEm);
	// }

	// public function scheduleInAction($idH, $idA)

	// {
	// 		return \DB::table('action_schedule')
	// 		          ->where('schedule_id', $idH)
	// 		          ->where('action_id', $idA);
	// }

	public function scheduleBetweenDifferences($star, $end)

	{
			return Schedule::where('departure_time', '>=', $star)
			                ->where('departure_time', '<', $end)
			                ->orderBy('departure_time', 'DESC');

	}

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

	public function scheduleInEmployeeDay($day)

	{
			return Schedule::with(['employee'])
			               ->where('days', 'LIKE', '%'.$day.'%');
	}

	public function scheduleInActionDay($day)

	{
			return Schedule::with(['actions', 'actions.employee'])
			                 ->where('days', 'Like', '%'.$day.'%');
	}

}