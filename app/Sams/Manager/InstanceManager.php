<?php

namespace Sams\Manager;

class InstanceManager extends BaseManager {

	public function getRules() {
		$date = current_date();
		$date = rest_date(1, $date);
	  $rules = [
	    'identity_card' => 'required|numeric',
	  	'referred' => 'required|in:presidency_inass,social_welfare,health,cssr,other',
	  	'address' => 'required',
	  	'description' => 'regex:/^[\pL\s]+$/u',
	  	'visit_date' => 'required|date|after:'.$date
	  ];
	  
	  return $rules;
	}

	public function getMessages() {
		$messages = [
      'indentity_card.required' => 'Ingrese cedula',
      'identity_card.numeric' => 'Cedula debe ser un numero',
      'indentity_card.unique' => 'Ya hay otro adulto mayor con esta cedula',
      'referred.required' => 'Ingrese desde donde es referido',
      'referred.in' => 'Referencia ingresada  es inválido',
      'address.required' => 'Ingrese direccion',
      'visit_date.required' => 'Ingrese fecha de visita social',
      'visit_date.date' => 'Ingrese formato de fecha valido para visita social',
      'visit_date.after' => 'Fecha ya paso'
    ];

    return $messages;
	}

	public function prepareData($data) {
	  $data['state'] = 'waiting';

	  return $data;
	}
	

}