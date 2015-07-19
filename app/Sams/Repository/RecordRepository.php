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

	public function createRecord($gender)

	{
			$record = new Record();
			
			$path = public_path().'\image\geriatric';

			if ($gender == 'm')

			{
					$record->image_url = $path.'\profile.default_man.jpg';
			}

			else

			{
					$record->image_url = $path.'\profile.default_woman.jpg';
			}

			$record->mime = 'jpg';
			return $record;
	}

	public function allRecord($id)

	{
      return Record::where('elder_id', $id)->orderBy('created_at', 'DESC');
	}

}