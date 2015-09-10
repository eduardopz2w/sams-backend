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
		                          RecordTask $recordTask)

	{
		$this->elderRepo  = $elderRepo;
	  $this->recordRepo = $recordRepo;
		$this->recordTask = $recordTask;
	}

	public function create($elderId) {
    $elder = $this->elderRepo->find($elderId);

    $this->recordTask->recordCurrentChangeState($elder->id);

    $record = $this->recordRepo->createRecord();
    $data = Input::all();
    $manager = new RecordManager($record, array_add($data,'elder_id', $elder->id));

    $manager->save();

    if (isset($data['photo'])){
      $this->recordTask->addImg($record, $data['photo'], $data['mime']);
    }

    return Response::json(['status'  => 'success',
                           'message' => 'Historia medica registrada']);
  }
		
  public function showRecord($id, $idRecord) {
    $elder = $this->elderRepo->find($id);
    $record = $this->recordRepo->record($idRecord, $elder->id);
    
    $this->notFound($record);

    return Response::json($record);
  }

  public function editRecord($id) {
    $record = $this->recordRepo->find($id);
    $data = Input::except('_method');
    $manager = new RecordEditManager($record, $data);
    $manager->save();

    if (isset($data['photo'])) {
      $this->recordTask->addImg($record, $data['photo'], $data['mime']);
    }
    
    return Response::json(['status'  => 'success',
                           'message' => 'Historia medica actualizada']);
  }
  	
	public function stateRecord($id) {
    $elder = $this->elderRepo->find($id);
    $record = $this->recordRepo->recordCurrent($elder->id);

    if ($record->count() > 0){
      $record = $record->first();
      $recordState = $this->recordTask->dateExpired($record->created_at);
    } else {
      $recordState = false;
    }
     
    return Response::json(['status' => 'success',
                           'recordState' => $recordState]);
  }

	

}