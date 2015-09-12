<?php

namespace Sams\Manager;

class OutputManager extends BaseManager {

	public function getRules() {
		$date = current_date();
		$date = rest_date('1', $date);
		$rules = [
			'type' => 'required|in:normal,pernot',
			'date_start' => 'required_if:type,pernot|date|after:'.$date,
			'date_end' => 'required_if:type,pernot|date',
			'info' => 'required_if:type,pernot'
		];
					
		return $rules;
	}
	
	public function prepareData($data) {
		$data['state'] = 0;

		return $data;
	}
		  
			
	

}