<?php

namespace Sams\Manager;

class ImageOccurrenceManager extends PictureManager {

	public function getDirName()

	{
			$idE = $this->entity->elder_id;
			return public_path().'\image\geriatric\occurrences'.'\elder'.$idE;
	}

	public function getNameFile()

	{
			$idF = $this->entity->id;
			return '\occurrence'.$idF.'.png';
	}

}