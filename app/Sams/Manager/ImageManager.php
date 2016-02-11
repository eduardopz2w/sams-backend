<?php

namespace Sams\Manager;

abstract class ImageManager {
 
	protected $entity;
	protected $img;
	protected $mime;

	public function __construct($entity, $img, $mimeSet) {
	  $this->entity = $entity;
	  $this->img = $img;
	  $this->mimeSet = $mimeSet;
	  $this->urlLocalhost = 'http://localhost';
	}
	
	public function uploadImg() {
	  $this->dirExists();

 	  $dir  = $this->getDirName();
 	  $file = $this->getNameFile();
 	  $path = $dir.$file;
 	  $img = str_replace('data:image/'.$this->mimeSet.';base64,', '', $this->img);
 	  $img = str_replace(' ',  '+', $img);
 	  $data = base64_decode($img);

 	  file_put_contents($path, $data);

 	  $this->entity->image_url = $this->getUrl($path);

 	  $this->entity->save();
 	}

	public function dirExists() {
 		$dir = $this->getDirName();

 		if (!file_exists($dir)) {
	  	  mkdir($dir);
 		} else {
 			$imgUrlDefault = $this->urlLocalhost.'/image/geriatric/default/profile_default_man.png';

  	 		if ($this->entity->image_url != $imgUrlDefault) {
	   			$path = $this->pathFile($this->entity->image_url);

	   			$this->imgDrop($path);
	 	 	}
 		}
	}

	public function imgDrop($path) {
 		if (file_exists($path)) {
 			unlink($path);
 		}
    }

	public function pathFile($imgUrl) {
	  	$dirPublic = public_path();
 	    $path = str_replace($this->urlLocalhost, $dirPublic, $imgUrl);

 	    return $path;
	}

	public function getUrl($path) {
		$dirPublic = public_path();
		$url = str_replace($dirPublic, $this->urlLocalhost, $path);

		return $url;
	}

  abstract public function getNameFile();
  abstract public function getDirName();
}