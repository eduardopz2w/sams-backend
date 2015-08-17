<?php

namespace Sams\Manager;

class ActionManager extends BaseManager {

	public function getRules()

	{
		  $date = current_date();

			$rules = [
				'description'    => 'required|regex:/^[\pL\s]+$/u',
				'type'           => 'required|in:normal,special',
				'responsible'    => 'required_without:employee_ident|regex:/^[\pL\s]+$/u',
				'date_day'       => 'required_if:type,special|date|after:'.$date,
				'hour_in'        => 'required_with:hour_out|date_format:H:i',
				'hour_out'       => 'date_format:H:i'
			];

			return $rules;
	}
 
	public function save()

	{
		  $this->entity->fill($this->prepareData($this->data));
			$this->entity->save();
			return $this->entity->id;
	}

	public function prepareData($data)

	{
		  array_pull($data, 'employee_ident');

		  $data['description'] = scapeText($data['description']);

			$data['state'] = 1;
			return $data;
	}

}