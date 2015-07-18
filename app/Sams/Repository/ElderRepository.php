<?php

namespace Sams\Repository;

use Sams\Entity\Elder;

class ElderRepository extends BaseRepository{
	
	public function getModel()

	{
			return new Elder;
	}

	public function findElderByIdentify($identify)

	{
			return Elder::where('identity_card', $identify);
	}
}