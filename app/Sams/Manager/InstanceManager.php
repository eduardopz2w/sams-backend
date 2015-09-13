<?php

namespace Sams\Manager;

class InstanceManager extends BaseManager {

	public function getRules() {
		$date = current_date();
	  $rules = [
	    'identity_card' => 'required|numeric',
	  	'referred' => 'required|in:presidency_inass,social_welfare,health,cssr,other',
	  	'address' => 'required',
	  	'description' => 'regex:/^[\pL\s]+$/u',
	  	'visit_date' => 'required|date|after:'.$date
	  ];
	  
	  return $rules;
	}

	public function prepareData($data) {
	  $data['state'] = 'waiting';

	  return $data;
	}
	

}