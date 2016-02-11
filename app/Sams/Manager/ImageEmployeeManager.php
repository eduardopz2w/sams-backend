<?php

namespace Sams\Manager;

class ImageEmployeeManager extends ImageManager {

	public function getDirName() {
	  return public_path().'/image/geriatric/employees/employee'.$this->entity->id;
	}

	public function getNameFile() {
	  $image = uniqid('/img', true);
	  $image = str_replace('.', '', $image);
	  $image = $image.$this->entity->id.'.'.$this->entity->mime;
	  
	  return $image;
	}

	
}