<?php

namespace Sams\Manager;

class InstanceEditManager extends BaseManager {

  public function getRules() {
    $date = current_date();
    $rules = [
      'identity_card' => 'required|numeric|unique:elders,identity_card,'.$this->entity->elder_id,
      'referred' => 'required|in:presidency_inass,social_welfare,health,cssr,other',
      'address' => 'required',
      'description' => 'regex:/^[\pL\s]+$/u',
      'visit_date' => 'required|date|after:'.$date
    ];
    
    return $rules;
  }
}