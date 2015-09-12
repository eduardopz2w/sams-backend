<?php

namespace Sams\Manager;

class CitationManager extends BaseManager {

	public function getRules() {
		$date = current_date();
		$day = 1;
		$date = rest_date($day, $date);
		$rules = [
			'date_day' => 'required|date|after:'.$date,
			'hour' => 'required|date_format:H:i',
			'reason' => 'required|regex:/^[\pL\s]+$/u'
		];

		return $rules;
	}
		 
	public function prepareData($data) {
		$data['state'] = 'loading';

		return $data;
	}
	

}