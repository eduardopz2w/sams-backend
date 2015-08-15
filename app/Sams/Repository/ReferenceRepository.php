<?php

namespace Sams\Repository;

use Sams\Entity\Reference;

class ReferenceRepository extends BaseRepository {

	public function getModel()

	{
			return new Reference;
	}

}