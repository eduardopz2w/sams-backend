<?php

namespace Sams\Repository;

use Sams\Entity\Action;

class ActionRepository extends BaseRepository {

	public function getModel()

	{
			return new Action;
	}

	public function getActionSpecial($date)

	{
		  return Action::leftJoin('employees', 'actions.employee_id', '=', 'employees.id')
		  						->where('date_day', $date);
	}

	public function actionForDescription($description)

	{
			return Action::where('description', $description);
	}


	public function actionInSchedule($idAction, $hourIn, $hourOut, $days)

	{
		 	return Action::with(

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

				}])->where('id', $idAction)->get();
	}

	public function scheduleInActioneEmployee($id, $hourIn, $hourOut, $days)

	{
				return Action::with(

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

				}])->where('employee_id', $id)->get();
	}





}


