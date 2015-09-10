<?php

namespace Sams\Repository;

use Sams\Entity\Action;

class ActionRepository extends BaseRepository {

	public function getModel() {
		return new Action;
	}

	public function getActions() {
		return Action::all();
	}

	public function actionInSchedule($id, $hourIn, $hourOut, $days) {
		return Action::with(
			['schedules' => function($q) use ($hourIn, $hourOut, $days) {
				$q->where('entry_time', '<=', $hourOut)
					->where('departure_time', '>=', $hourOut)
					->where('days', 'LIKE','%'.$days.'%')
					->orWhere(function($query) use ($hourIn, $hourOut, $days) {
							$query->where('entry_time', '>=', $hourIn)
						  	->where('departure_time', '<=', $hourOut)
						  	->where('days', 'LIKE','%'.$days.'%');
					})->orWhere(function($query) use ($hourIn, $hourOut, $days) {
						$query->where('entry_time', '<', $hourIn)
							->where('departure_time', '>=', $hourIn)
							->where('departure_time', '<=', $hourOut)
							->where('days', 'LIKE','%'.$days.'%');
				  });
			}])->where('id', $id)->get();
	}


}


