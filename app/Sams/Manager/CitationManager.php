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
			'reason' => 'required'
		];

		return $rules;
	}

	public function getMessages() {
		$messages = [
			'date_day.required' => 'Ingrese fecha',
			'date_day.date' => 'Ingrese formato de fecha valido',
			'date_day.after' => 'Fecha ya ha pasado',
			'hour.required' => 'Ingrese hora',
			'hour.date_format' => 'Ingrese formato de hora valido',
			'reason.required' => 'Ingrese motivo'
		];

		return $messages;
	}
		 
	public function prepareData($data) {
		$data['state'] = 'loading';

		return $data;
	}
	

}