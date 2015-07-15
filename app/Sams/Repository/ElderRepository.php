<?php

namespace Sams\Repository;

use Sams\Entity\Elder;

class ElderRepository extends BaseRepository{
	
	public function getModel()

	{
			return new Elder;
	}
}