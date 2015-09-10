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
	  return Instance::where('elder_id', $id)
			             ->where('state', 'confirmed');
	}

	public function getInstanceVisited()

	{
	  $date = current_date();
		return Instance::where('visit_date', $date)
			             ->where('state' ,'waiting');
	}

	public function instanceWaiting($elderId)

	{
	  return Instance::where('elder_id', $elderId)
	                 ->where('state', 'waiting');
	}

}