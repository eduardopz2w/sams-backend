<?php

namespace Sams\Task;
use Sams\Repository\ElderRepository;

class InstanceTask extends BaseTask {

	protected $elderRepo;

	public function __construct(ElderRepository $elderRepo)

	{
			$this->elderRepo = $elderRepo;
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
			$this->instanceWaiting($elder);
		  $this->elderResident($elder);
	}

	public function instanceWaiting($elder)

	{
		  $instanceWaiting = $elder->getInstanceWaiting();
		  
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


	public function confirmInstance($instance)

	{
			$instance->admission_date = current_date();
			$instance->state = 'confirmed';
			$instance->save();

			$this->confirmedElder($instance);
	}

	public function confirmedElder($instance)

	{
			$elder = $instance->elder;
			$elder->activiti = 1;
			$elder->save();
	}

}