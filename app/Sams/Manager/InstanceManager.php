<?php

namespace Sams\Manager;

class InstanceManager extends BaseManager {

	public  function createInstance($elder)

	{
		  // $this->isValid();

		  if (!$elder->id)

		  {
		  		$dataElder = array_only($this->data, ['identity_card', 'full_name']);
		  		$elder->fill(array_add($dataElder, 'activiti', 0));
		  		$elder->save();
		  }

		  else

		  {
		  		$this->instanceWaiting($elder);
		  		$this->elderResident($elder);
		  }
		 
		  $this->data = array_add($this->data, 'elder_id', $elder->id);
		  $this->save();
		
	}

	public function save()

	{
			
			$this->data = array_only($this->data, ['elder_id', 'referred', 'address', 'visit_date', 'description']);
			$this->entity->fill($this->prepareData($this->data));

			$this->entity->save();
	}

	public function instanceWaiting($elder)

	{
		  $instanceWaiting = $elder->getInstanceWaiting();
			if ($instanceWaiting->count() > 0)

			{
					throw new ValidationException("Error Processing Request", 'Debe confirmar notificacion pendiente');
					
			}
	}

	public function elderResident($elder)

	{
		 if ($elder->activiti)

		 {
					throw new ValidationException("Error Processing Request", 'Adulto Mayor ya residenciado');

		 }
	}

	public function prepareData($data)

	{
			$data['state'] = 'waiting';
			return $data;
	}

}