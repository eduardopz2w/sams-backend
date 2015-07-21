<?php

namespace Sams\Manager;

class ImageEmployeeManager extends PictureManager {

	public function getNameFile()

	{
			$idF  = $this->entity->id;
			$mime = $this->entity->mime;
			return '\img'.$idF.'.'.$mime;
	}

	public function getDirName()

	{
		  $idE = $this->entity->id;
			return public_path().'\image\geriatric\employees'.'\employee'.$idE;
	}
	public function getFormatNameFile()

	{
		 $file = $this->getSpaceExtensions();
		 return $formatNameFile  = str_replace('\img', 'img', $file);
	}


}