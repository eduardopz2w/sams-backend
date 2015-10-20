<?php

namespace Sams\Manager;

class InstanceEditManager extends BaseManager {

  public function getRules() {
    
    $state = $this->entity->state;

    if ($state == 'waiting') {
      $date = current_date();
      $date = rest_date(1, $date);
      $rules = [
        'identity_card' => 'required|numeric|unique:elders,identity_card,'.$this->entity->elder_id,
        'referred' => 'required|in:presidency_inass,social_welfare,health,cssr,other',
        'address' => 'required',
        'visit_date' => 'required|date|after:'.$date
      ];
    } else {
      $rules = [
        'identity_card' => 'required|numeric|unique:elders,identity_card,'.$this->entity->elder_id,
        'referred' => 'required|in:presidency_inass,social_welfare,health,cssr,other',
        'address' => 'required',
        'visit_date' => 'required|date'
      ];
    }
    
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
}