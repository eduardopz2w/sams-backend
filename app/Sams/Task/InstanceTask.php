<?php

namespace Sams\Task;
use Sams\Repository\ElderRepository;
use Sams\Repository\InstanceRepository;

class InstanceTask extends BaseTask {

	protected $elderRepo;
	protected $instanceRepo;

  public function __construct(ElderRepository $elderRepo, 
  	                          InstanceRepository $instanceRepo) {
  	$this->elderRepo    = $elderRepo;
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
			$message = 'Adulto mayor posee notificacion de registro por confirmar';

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

	public function confirmInstance($instance, $state) {
		if ($state == 'confirmed') {
			$message = 'Notificacion confirmada';
		} else {
			$message = 'Notificacion rechazada';
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
			$message = 'No hay notificaciones de entradada por confirmar';

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


}