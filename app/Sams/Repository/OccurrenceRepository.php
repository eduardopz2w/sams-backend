<?php

namespace Sams\Repository;

use Sams\Entity\Occurrence;

class OccurrenceRepository extends BaseRepository {

	 public function getModel()

	 {
	 		 return new Occurrence;
	 }

}