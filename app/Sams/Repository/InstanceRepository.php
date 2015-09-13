<?php

namespace Sams\Repository;

use Sams\Entity\Instance;

class InstanceRepository extends BaseRepository{
	
	public function getModel() {
		return new Instance;
	}

	public function getInstanceVisited($date) {
		return Instance::join('elders', 'instances.elder_id', '=', 'elders.id')
		               ->select(
		               		'elders.identity_card',
		               		'instances.referred',
		               		'instances.address',
		               		'instances.visit_date',
		               		'instances.description'
		               	)
		               ->where('visit_date', '<=', $date)
			             ->where('state' ,'waiting')
			             ->orderBy('visit_date', 'DESC');
	}

	
		
	


}