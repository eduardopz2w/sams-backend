<?php

namespace Sams\Repository;

use Sams\Entity\Instance;

class InstanceRepository extends BaseRepository{
	
	public function getModel()

	{
			return new Instance;
	}
}