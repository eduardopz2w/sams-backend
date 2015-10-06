<?php

namespace Sams\Repository;

use Sams\Entity\Permit;

class PermitRepository extends BaseRepository {

	public function getModel() {
	 	return new Permit;
	}
	
	 

}

