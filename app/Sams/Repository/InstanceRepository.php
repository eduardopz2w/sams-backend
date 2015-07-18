<?php

namespace Sams\Repository;

use Sams\Entity\Instance;

class InstanceRepository extends BaseRepository{
	
	public function getModel()

	{
			return new Instance;
	}

	public function getInstanceConfirmed($id)

	{
			return Instance::where('elder_id', $id)->where('state', 'confirmed');
	}

}