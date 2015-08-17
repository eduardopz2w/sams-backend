<?php

namespace Sams\Repository;

use Sams\Entity\Relative;

class RelativeRepository extends BaseRepository {

	public function getModel()

	{
		 return new Relative;
	}

	public function findRelativeForByIdentify($identify, $idElder)

	{
		 return Relative::where('identity_card', $identify)
		 								->where('elder_id', $idElder);
	}

}