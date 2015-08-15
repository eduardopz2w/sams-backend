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

	public function createRecord()

	{
			$record = new Record();
			
			$record->image_url = 'http://localhost/image/geriatric/profile_default_man.jpg';
			$record->mime      = 'jpg';
			
			return $record;
	}

	public function allRecord($id)

	{
      return Record::where('elder_id', $id)->orderBy('created_at', 'DESC');
	}

}