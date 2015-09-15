<?php

namespace Sams\Manager;

class ImageOccurrenceManager extends ImageManager {

	public function getDirName() {
	  return public_path().'\image\geriatric\occurrences\elder'.$this->entity->elder_id;
	}

	public function getNameFile() {
		$ocurrence = uniqid('\ocurrence', true);
		$ocurrence = str_replace('.', '', $ocurrence);
		$ocurrence = $ocurrence.$this->entity->id.'.'.$this->entity->mime;

		return $ocurrence;
	}

}