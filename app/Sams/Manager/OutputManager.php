<?php

namespace Sams\Manager;

class OutputManager extends BaseManager {

	public function getRules()
	
	{
		  $date       = current_date();
		  $dateAfter  = rest_date('1', $date);

			$rules = [
				'type'          => 'required|in:normal,pernot',
				'date_init'     => 'required_if:type,pernot|date|after:'.$dateAfter,
				'date_end'      => 'required_if:type,pernot|date',
				'address'       => 'required_if:type,pernot',
				'accompanist'   => 'required_if:type,pernot'

			];
					
			return $rules;
	}

	public function save()

	{
		  $data = array_only($this->data, ['date_init', 'date_end', 'address',
		  	                               'elder_id', 'type']);

			$this->entity->fill($this->prepareData($data));
			$this->entity->save();

			return $this->entity;
	}

	public function prepareData($data)

	{
		  if ($data['type'] == 'normal')

		  {
		  		$data['hour_output'] = date('H:i');
		  }
		  
			$data['state'] = 1;
			return $data;
	}

}