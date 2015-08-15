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

		  $this->data = array_add($this->data, 'elder_id', $elder->id);
		  $this->save();
		
	}

	public function save()

	{ 
			$this->data = array_only($this->data, ['elder_id', 'referred', 'address', 
				                                     'visit_date', 'description']);

			$this->entity->fill($this->prepareData($this->data));
			$this->entity->save();

	}

	public function prepareData($data)

	{
			$data['state'] = 'waiting';
			return $data;
	}

}