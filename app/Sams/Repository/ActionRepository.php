<?php

namespace Sams\Repository;

use Sams\Entity\Action;

class ActionRepository extends  BaseRepository {

	public function getModel()

	{
			return new Action;
	}

	public function getActionSpecial($date)

	{
		  return Action::where('date_day', $date);
	}




}
