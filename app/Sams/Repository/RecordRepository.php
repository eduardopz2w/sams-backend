<?php

namespace Sams\Repository;

use Sams\Entity\Record;

class RecordRepository extends BaseRepository {

	public function getModel()

	{
	  return new Record;
	}

	public function createRecord()

	{
	  $record = new Record();
	  $record->image_url = 'http://localhost/image/geriatric/default/profile_default_man.png';
	  $record->mime = 'jpg';	
	  return $record;
	}

	public function record($idRecord, $idElder)

	{
	  return Record::where('id', $idRecord)
	               ->where('elder_id', $idElder)
	               ->first();
	}

	public function recordCurrent($id)

	{
	  return Record::where('elder_id', $id)->where('state', 1);
	}

	// public function totalRecords($id)

	// {
 //    return Record::where('elder_id', $id)->orderBy('created_at', 'DESC');
	// }

}