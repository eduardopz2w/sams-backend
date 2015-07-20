<?php

namespace Sams\Manager;

abstract class PictureManager {
 
	protected $entity;
	protected $img;
	protected $widthStandard;
	protected $heightStandard;

	public function __construct($entity, $img)

	{
			$this->entity         = $entity;
			$this->img            = $img;
			$this->widthStandard  = 1056;
			$this->heightStandard = 1056;
	}

  public function upload()

	{
		  $this->isImgValid();
		  $this->dirConfig();
			$mime = $this->img->getClientOriginalExtension();
			$file = $this->getFormatNameFile();
			$file .=  '.'.$mime;

			$dir  = $this->getDirName();
			$this->img->move($dir, $file);
			$this->mime = $mime;
			$this->save();

	}

	public function uploadCode()

	{
		  $img  = $this->img;
		  $this->dirConfig();
		  $dir  = $this->getDirName();
		  $mime = 'png';
		  $file = $this->getSpaceExtensions();
		  $file .=  '.'.$mime;
		  $path = $dir.$file;

			$img  = str_replace('data:image/png;base64,','', $img);
			$img  = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			file_put_contents($path, $data);
			$this->mime = 'png';
			$this->save();
	}


	public function isImgValid()

	{
		  $rules = $this->getImgRules();
		  $file = ['photo' => $this->img];
		  $validator = \Validator::make($file, $rules);
		
		  if ($validator->fails())

		  {
		  		throw new ValidationException("Error Processing Request", $validator->messages());
		  }

		  $this->confirmedSize();
	}

	public function getImgRules()

	{
			 $rules = [
				'photo' => 'required'
			];

			return $rules;

	}

	public function confirmedSize()

	{
			$imgDetail =  getimagesize($this->img);
			$width     = $imgDetail[0];
			$height    = $imgDetail[1];

			$this->allowableSize($width, $height);
			
	}

	public function allowableSize($width, $height)

	{
			$widthStandard  = $this->widthStandard;
			$heightStandard = $this->heightStandard;

			if ($width > $widthStandard || $height > $heightStandard)

			{
					throw new ValidationException('Error Processing Request', 
						                            'Tamaño de imagen debe ser menor a '.$widthStandard.' x '.$heightStandard);
			}
	}


  public function dirConfig()

	{
			$dir  = $this->getDirName();
		  $file = $this->getNameFile();

			$this->dirExists($dir);
			$this->imageDrop($dir, $file);

	}

	public function dirExists($dir)

	{
			if (!file_exists($dir))

			{
					mkdir($dir);
			}
	}

	public function imageDrop($dir, $file)

	{
			$path = $dir.$file;

			if (file_exists($path))

			{
					unlink($path);
			}
	}

	public function save()

	{
			$file    = $this->getNameFile();
			$dir     = $this->getDirName();
			$imagUrl = $dir.$file;

			$this->entity->image_url = $imagUrl;
			$this->entity->mime =  $this->mime;
			$this->entity->save();
	}

	public function getFormatNameFile()

	{
		 $file = $this->getSpaceExtensions();
		 return $formatNameFile  = str_replace('\h', 'h', $file);
	}

	public function getSpaceExtensions()

	{
			$file    = $this->getNameFile();
			$segment = explode('.', $file);
			return $segment[0];
	}
  
  abstract public function getNameFile();
  abstract public function getDirName();

}