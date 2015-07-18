<?php

namespace Sams\Repository;

use Sams\Entity\Record;

class RecordRepository extends BaseRepository {

	public function getModel()

	{
			return new Record;
	}

	public function getRecordDeprecated($id)

	{
			return Record::where('elder_id', $id)->where('state', false);
	}

	public function getRecordCurrent($id)

	{
			return Record::where('elder_id', $id)->where('state', true);
	}

}