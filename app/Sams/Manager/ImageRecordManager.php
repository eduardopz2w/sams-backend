<?php

namespace Sams\Manager;

class ImageRecordManager extends ImageManager {

	public function getDirName()

	{
	  return public_path().'\image\geriatric\records\elder' . $this->entity->elder_id;
	}

	public function getNameFile()

	{
		$history = uniqid('\history', true);
		$history = str_replace('.', '', $history);
		$history = $history.$this->entity->id.'.'.$this->entity->mime;

		return $history;
	}

}