<?php

use Sams\Manager\ImageRecordManager;
use Sams\Repository\RecordRepository;
use Sams\Repository\ElderRepository;
use Sams\Task\ElderTask;

class ImgController extends BaseController {
	
	 protected $recordRepository;
	 protected $elderRepository;
	 protected $elderTask;

	 public function __construct(RecordRepository $recordRepository, ElderRepository $elderRepository,
	 	                           ElderTask $elderTask)

	 {
	 			$this->recordRepository = $recordRepository;
	 			$this->elderRepository  = $elderRepository;		
	 			$this->elderTask        = $elderTask;
	 }

	 public function addRecordImg($id)

	 {
	 			$elder = $this->elderRepository->find($id);
	 			$this->elderTask->elderActiviti($elder);
	 			$record = $this->recordRepository->allRecord($elder->id)->first();

	 			if (Input::hasFile('photo'))

	 			{
	 					$manager = new ImageRecordManager($record, Input::file('photo'));
	 					$manager->addImage();
	 			}

	 			return Response::json(['status'  => 'success',
	 				                     'message' => 'se ha cambiado la imagen']);
	 }

}