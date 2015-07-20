<?php

namespace Sams\Manager;

class ImageRecordManager extends PictureManager {

	
	public function getNameFile()

	{
		  $idH  = $this->entity->id;
		  $mime = $this->entity->mime;

		  return '\history'.$idH.'.'.$mime;
	}

	public function getDirName()

	{
			$idE  = $this->entity->elder_id;
			return public_path().'\image\geriatric\records'.'\elder'.$idE;
	}


}