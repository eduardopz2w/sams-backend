<?php

namespace Sams\Task;
use Sams\Repository\ElderRepository;
use Sams\Repository\InstanceRepository;

class InstanceTask extends BaseTask {

	protected $elderRepo;
	protected $instanceRepo;

  public function __construct(ElderRepository $elderRepo, 
  	                          InstanceRepository $instanceRepo) {
  	$this->elderRepo = $elderRepo;
	  $this->instanceRepo = $instanceRepo;
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
	  
	public function elderFound($identityCard) {
		$elder = $this->elderRepo->findElderByIdentify($identityCard);

	  if ($elder->count() > 0) {
	  	$elder = $elder->first();

	  	$this->confirmElder($elder);

		  return $elder;
	  }
		
		else {
		  $elder = $this->elderRepo->getModel();
		  $elder = $elder->create(['identity_card' => $identityCard]);

		  return $elder;
		}
	}
	 
	public function confirmElder($elder) {
		if ($elder->activiti) {
			$message = 'Adulto mayor ya es residente';

			$this->hasException($message);
		}

		$instance = $elder
									->instances()
										->where('state', 'waiting');

		if ($instance->count() > 0) {
			$message = 'Adulto mayor posee notificacion de entrada por confirmar';

			$this->hasException($message);
		}
	}

	public function format($elder, $instance) {
		$instance = [
		  'id' => $instance->id,
			'referred' => \Lang::get('utils.referred_instance.'.$instance->referred),
	  	'address' => $instance->address,
	  	'visit_date'=> $instance->visit_date,
	  	'description' => $instance->description,
	  	'elder_id' => $elder->id,
	  	'identity_card' => $elder->identity_card,
	  	'full_name' => $elder->full_name,	
	  ];

	  return $instance;
	}

	public function confirmInstance($elder, $instance, $state) {
		$date = current_date();
		$visitDate = $instance->visit_date;
    
    if ($date < $visitDate) {
    	$message = 'Todavia no ha pasado fecha de visita social';

    	$this->hasException($message);
    }


		if ($state == 'confirmed') {
			$elder->activiti = 1;

			$elder->save();
			
			$message = 'Notificacion de entrada confirmada';
		} else {
			$message = 'Notificacionde entrada rechazada';
		}

		$instance->state = $state;
		$instance->save();

		$response = [
			'status' => 'success',
			'message' => $message
		];

		return $response;
	}

	public function getInstancesWaiting() {
		$date = current_date();
		$instances = $this->instanceRepo->getInstanceVisited($date);

		if ($instances->count() == 0) {
			$message = 'No hay visitas sociales por confirmar';

			$this->hasException($message);
		}
    
    $instances = $instances->get();

    return $instances;
	}

	public function getInstancesElder($elder) {
		$instances = $elder->instances();

		if ($instances->count() == 0) {
			$message = 'Adulto mayor no posee notifacion de entrada registradas';

			$this->hasException($message);
		}

		$instances = $instances->get();

		return $instances;
	}

	public function getInstancesDate($date) {
		$this->validateDate($date);

		$instances = $this->instanceRepo->getForDate($date);

		if ($instances->count() == 0) {
			$message = 'No hay visitas registradas para esta fecha';

			$this->hasException($message);
		}

		$instances = $instances->get();

		return $instances;
	}

	public function validateDate($date) {
		$date = ['date' => $date];
    $rules = ['date' => 'required|date'];
    $messages = [
      'date.required' => 'Ingrese fecha',
      'date.date' => 'Ingrese formato de fecha valido'
    ];

    $validator = \Validator::make($date, $rules, $messages);

    if ($validator->fails()) {
      $message = $validator->messages();

      $this->hasException($message);
    }
	}


}