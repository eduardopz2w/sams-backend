<?php

namespace Sams\Manager;

class InstanceManager extends BaseManager {

	public  function createInstance($elder)

	{
		  // $this->isValid();
		  $dateElder = array_only($this->data, ['identity_card', 'full_name']);
		  $elder->fill($dateElder);
		  $elder->save();

		  if (array_key_exists('elder_id', $this->data))

		  {
		  		array_except($this->data, ['elder_id']);
		  }

		  $this->data = array_add($this->data, 'elder_id', $elder->id);
		  $this->save();
		
	}

	public function save()

	{
			
			$this->data = array_only($this->data, ['elder_id', 'referred', 'address', 'visit', 'description']);
			$this->entity->fill($this->prepareData($this->data));

			$this->entity->save();
	}

	public function prepareData($data)

	{
			$data['state'] = 0;
			return $data;
	}
}