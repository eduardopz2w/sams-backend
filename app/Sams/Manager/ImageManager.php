<?php

namespace Sams\Manager;

abstract class ImageManager {
 
	protected $entity;
	protected $img;
	protected $mime;

	public function __construct($entity, $img, $mimeSet) {
		$this->entity  = $entity;
	  $this->img     = $img;
	  $this->mimeSet = $mimeSet;
	}
	
	public function uploadImg() {
		$this->dirExists();

		$img  = $this->img;
 	  $dir  = $this->getDirName();
 	  $file = $this->getNameFile();
 	  $path = $dir.$file;
 	  $mimeSet = $this->mimeSet;
 	  $img = str_replace('data:image/'.$mimeSet.';base64,', '', $img);
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
 				$urlDefault = 'http://localhost/image/geriatric/default/profile_default_man.png';
  	 		$imageUrl = $this->entity->image_url;

  	 		if ($imageUrl != $urlDefault) {
	   			$path = $this->replaceHttp($this->entity->image_url);

	   			$this->imgDrop($path);
	 	 		}
 			}
	}

	public function imgDrop($path) {
 		if (file_exists($path)) {
 			unlink($path);
 		}
  }

	public function replaceHttp($dir) {
		$dirPublic = public_path();
 	  $path = str_replace('http://localhost', $dirPublic, $dir);

 	  return $path;
	}

	public function getUrl($path) {
		$dirPublic = public_path();
		$url = str_replace($dirPublic, 'http://localhost', $path);
		$url = str_replace('\\', '/', $url);

		return $url;
	}

  abstract public function getNameFile();
  abstract public function getDirName();
}