<?php

namespace Sams\Task;
use Sams\Repository\ElderRepository;
use Sams\Repository\InstanceRepository;

class InstanceTask extends BaseTask {

	protected $elderRepo;
	protected $instanceRepo;

  public function __construct(ElderRepository $elderRepo, InstanceRepository $instanceRepo)

	{
	  $this->elderRepo    = $elderRepo;
	  $this->instanceRepo = $instanceRepo;
	}

	public function elderFound($identityCard)

	{
	  $elder = $this->elderRepo->findElderByIdentify($identityCard);

	  if ($elder->count() > 0)

	  {
		  $elder = $elder->first();
		}

		else

		{
		  $elder = $this->elderRepo->getModel();
		}

		return $elder;
	}

	public function confirmElder($elder)

	{
	  $this->instanceWaiting($elder->id);
    $this->elderResident($elder);
	}

	public function instanceWaiting($idElder)

	{
	  $instanceWaiting = $this->instanceRepo->instanceWaiting($idElder);
		  
		if ($instanceWaiting->count() > 0)

		{
		  $message = 'Debe confirmar notificacion pendiente';
		  $this->hasException($message);	
		}
	}

	public function elderResident($elder)

	{
	  if ($elder->activiti)

		{
		  $message = 'Adulto Mayor ya residenciado';
		  $this->hasException($message);
		}
	}


	public function confirmInstance($instance, $state)

	{
	  if ($state == 'confirmed')

		{
	  	$instance->state = $state;
	  	$instance->save();
			$this->confirmedElder($instance);

			$response = ['status'  => 'success',
			             'message' => 'Notificacion de entrada confirmada'];
		}

		else

		{
		  $instance->state = $state;
		  $instance->save();

		  $response = ['status' => 'info',
		               'message' => 'Notificacion de entrada ha sido rechazada'];
		}

		return $response;

	}

	public function confirmedElder($instance)

	{
	  $elder = $instance->elder;
	  $elder->activiti = 1;
	  $elder->save();
	}

	public function maxElders()

	{
	  $config   = get_configuration();
	  $maxElder = $config->max_impeachment;
	  $state    = 'active';
	  $elders   = $this->elderRepo->elders($state);

	  if ($maxElder == $elders->count())

	  {
	    $message = 'El maximo de adultos residentes es de'.$maxElder;
	    $this->hasException($message);
	  }

	}

	public function format($instance) {
		$elder = $instance->elder;
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

}