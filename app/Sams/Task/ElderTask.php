<?php

namespace Sams\Task;

use Sams\Repository\ElderRepository;
use Sams\Repository\RecordRepository;

class ElderTask extends BaseTask {

	protected $elderRepo;
	protected $recordRepo;
	protected $citationRepo;
	protected $instanceRepo;

	public function __construct(ElderRepository $elderRepo,
                              RecordRepository $recordRepo) {
    $this->elderRepo  = $elderRepo;
    $this->recordRepo = $recordRepo;
  }

  public function maxElders() {
    $config = get_configuration();
    $maxElder = $config->max_impeachment;
    $state = 'active';
    $elders = $this->elderRepo->elders($state);
    $count = $elders->count();

    if ($maxElder == $count) {
      $message = 'El maximo de adultos residentes es de'.$maxElder;

      $this->hasException($message);
    }
  }

  public function format($elder) {
    $instance = $elder
                  ->instances()
                    ->where('state', 'waiting')
                    ->count();
    $citation = $elder
                  ->citations()
                    ->count();
    $elder = [
      'identity_card' => $elder->identity_card,
      'full_name' => $elder->full_name,
      'address' => $elder->address,
      'gender' => $elder->gender,
      'retired' => $elder->retired,
      'pensioner' => $elder->pensioner,
      'civil_status' => \Lang::get('utils.civil_status.'. $elder->civil_status),
      'date_birth' => $elder->date_birth,
      'activiti' => $elder->activiti,
      'image_url'=> $elder->image_url,
      'citation' => $citation,
      'instance' => $instance
    ];
              
    return $elder;
  }


	public function getElders($state) {
    $elders = $this->elderRepo->elders($state);

    if ($elders->count() == 0) {
      if ($state == 'active') {
        $message = 'No hay registro de adultos residentes';
      } else {
        $message = 'No hay registro de adultos mayores';
      }

      $this->hasException($message);
    }

    $elders = $elders->get();

    return $elders;
  }

}