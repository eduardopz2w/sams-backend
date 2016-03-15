<?php

namespace Sams\Repository;

use Sams\Entity\Record;

class RecordRepository extends BaseRepository {

	public function getModel() {
    return new Record;
  }

  public function recordCurrent($elderId) {
	  return Record::where('elder_id', $elderId)->where('state', 1);
  }


}