<?php

namespace Sams\Manager;

class PermitManager extends BaseManager {
  
	public function validPermit() {
    $this->isValid();
    $this->entity->fill($this->prepareData($this->data));

    return $this->entity;
  }

  public function save() {
    $this->entity->save();
  }

  public function getRules() {
    $day = current_date();
    $rules = [
      'reason' => 'required|regex:/^[\pL\s]+$/u',
      'turn' => 'required_if:type,normal|in:morning,afternoon,night,complete',
      'type' => 'required|in:extend,normal',
      'date_star' => 'required|date|after:'.$day,
      'date_end' => 'required_if:type,extend|date'
    ];

    return $rules;
  }

  public function prepareData($data) {
    $data['state'] = 1;

    return $data;
  }

}

 