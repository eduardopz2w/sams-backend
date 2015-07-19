<?php

namespace Sams\Manager;

class ImageRecordManager extends BaseManager {

	public function addImage()

	{
			// $this->isValid();
			$img = $this->data;

			$imgDetail = getimagesize($img);
			$width     = $imgDetail[0];
			$height    = $imgDetail[1];

			$this->confirmSized($width,$height);
			$this->upload($img);
			
	}

	public function confirmSized($width, $height)

	{
			$widthStandard  = 1056;
			$heightStandard = 1056;

			if ($width > $widthStandard || $height > $heightStandard)

			{
					throw new ValidationException('Error Processing Request', 
						                            'Tamaño de imagen debe ser menor a '.$widthStandard.' x '.$heightStandard);
			}
	}

	public function upload($img)

	{
			$this->dirConfig();

			$file     = $this->getNameFile();
			$dir      = $this->getDirName();
			$nameFile = str_replace('\h', 'h', $file);

			$img->move($dir, $nameFile);

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

	public function getNameFile()

	{
		  $idH      = $this->entity->id;
		  $mime     = $this->entity->mime;

		  return '\history'.$idH.'.'.$mime;
	}

	public function getDirName()

	{
			$idE  = $this->entity->elder_id;
			return public_path().'\image\geriatric\records'.'\elder'.$idE;
	}

}