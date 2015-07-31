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

	public function scheduleInEmployee($idH, $idEm)

	{
			return \DB::table('employee_schedule')
			          ->where('schedule_id', $idH)
								->where('employee_id', $idEm);
	}

	/*public function scheduleInterval($star, $end)

	{
			return Schedule::where('entry_time', '>=', $star)
			                 ->where('entry_time', '<=', $end);
	}*/

	public function timesToday($day)

	{
			return Schedule::where('days', 'LIKE', '%'.$day.'%');
	}

	public function intervalSchedule($star, $end)

	{
			return Schedule::where('entry_time', '<=', $end)
			                ->where('departure_time','>=', $end)
			                ->orWhere(function($q) use ($star, $end)  {
			                		$q->where('entry_time', '>=', $star)
			                		  ->where('departure_time', '<=', $end);
			                })
			                ->orWhere(function($q) use ($star, $end) {
			                		$q->where('entry_time', '<', $star)
			                		  ->where('departure_time', '>=', $star)
			                		  ->where('departure_time', '<=', $end);
			                });
			               
	}

}