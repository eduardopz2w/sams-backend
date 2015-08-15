<?php

namespace Sams\Manager;

class ActionManager extends BaseManager {

	public function getRules()

	{
		  $date = current_date();

			$rules = [
				'description' => 'required|unique:actions',
				'type'        => 'required|in:normal,special',
				'responsible' => 'required_without:employee_id|regex:/^[\pL\s]+$/u',
				'employee_id' => 'required_without:responsible',
				'date_day'    => 'required_if:type,special|date|after:'.$date,
				'hour_in'     => 'required_with:hour_out|date_format:H:i',
				'hour_out'    => 'required_with:hour_in|date_format:H:i'
			];

			return $rules;
	}

	public function validateAction()

	{	
			$this->isValid();
			$this->entity->fill($this->prepareData($this->data));
			return $this->entity;
	}


	public function save()

	{
			$this->entity->save();
			return $this->entity->id;
	}

	public function prepareData($data)

	{
			if (!empty($data['employee_id']) && !empty($data['responsible']))

			{
					array_pull($data, 'responsible');
			}

			elseif (!empty($data['responsible']))

			{
					array_pull($data, 'employee_id');
			}

			$this->confirmHours($data);

			$data['state'] = 1;

			return $data;
	}

	public function confirmHours(&$data)

	{
			if ($data['type'] == 'normal')

			{
					array_pull($data, 'hour_in');
					array_pull($data, 'hour_out');
					array_pull($data, 'date_day');
			}
	}

}