<?php

use Sams\Manager\RecordManager;
use Sams\Manager\RecordEditManager;
use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;
use Sams\Task\RecordTask;

class RecordController extends BaseController {

	protected $recordRepo;
	protected $elderRepo;
	protected $recordTask;

	public function __construct(ElderRepository $elderRepo, 
                              RecordRepository $recordRepo,
		                          RecordTask $recordTask) {
    $this->elderRepo  = $elderRepo;
    $this->recordRepo = $recordRepo;
    $this->recordTask = $recordTask;
  }

	public function create($elderId) {
    $elder = $this->elderRepo->find($elderId);

    $this->recordTask->recordCurrentChangeState($elder);

    $record = $this->recordRepo->getModel();
    $data = Input::all();
    $manager = new RecordManager($record, $data);
    $record = $manager->saveRelation();

    $elder->records()->save($record);

    if (isset($data['photo'])){
      $photo = $data['photo'];
      $mime = $data['mime_request'];

      $this->recordTask->addImg($record, $photo, $mime);
    }

    $response = [
      'status' => 'success', 
      'message' => 'Historia medica registrada',
      'data' => $record
    ];

    return Response::json($response);
  }
		
  public function show($elderId, $recordId) {
    $elder = $this->elderRepo->find($elderId);
    $record = $elder
                ->records()
                  ->where('id', $recordId)
                  ->first();
    
    $this->notFound($record);

    $response = [
      'status' => 'success',
      'data' => $record
    ];

    return Response::json($response);
  }

  public function edit($elderId, $recordId) {
    $record = $this->recordRepo->find($recordId);
    $data = Input::except('_method');
    $manager = new RecordEditManager($record, $data);

    $manager->edit();

    if (isset($data['photo'])) {
      $photo = $data['photo'];
      $mime = $data['mime_request'];

      $this->recordTask->addImg($record, $photo, $mime);
    }

    $response = [
      'status' => 'success',
      'message' => 'Historia clinica actualizada'
    ];
    
    return Response::json($response);
  }

  public function delete($elderId, $recordId) {
    $record = $this->recordRepo->find($recordId);

    $record->delete();

    $response = [
      'status' => 'success',
      'message' => 'Historia clinica eliminada'
    ];

    return Response::json($response);
  }

  public function recordsForElder($elderId) {
    $elder = $this->elderRepo->find($elderId);
    $records = $this->recordTask->getRecordsForElder($elder);
    $response = [
      'status' => 'success',
      'data' => $records
    ];

    return Response::json($response);
  }
  	
	public function state($elderId) {
    $elder = $this->elderRepo->find($elderId);
    $record = $this->recordRepo->recordCurrent($elder->id);

    if ($record->count() > 0){
      $record = $record->first();
      $recordState = $this->recordTask->dateExpired($record->created_at);
    } else {
      $recordState = false;
    }

    $response = [
      'status' => 'success',
      'recordState' => $recordState
    ];
     
    return Response::json($response);
  }

	

}