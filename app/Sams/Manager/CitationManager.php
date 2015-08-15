<?php

namespace Sams\Manager;

class CitationManager extends BaseManager {

	public function getRules()

	{
		  $day = current_date();

			$rules = [
			  'address'  => 'required',
			  'date_day' => 'required|date|after:'.$day,
			  'hour'     => 'required|date_format:H:i',
			  'reason'   => 'required|regex:/^[\pL\s]+$/u'
			];

			return $rules;
	}

	public function save()

	{
			$this->entity->fill($this->prepareData($this->data));
			$this->entity->save();
	}

	public function prepareData($data)

	{
			$data['state'] = 'loading';
			return $data;
	}

}