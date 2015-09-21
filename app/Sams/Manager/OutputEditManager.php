<?php

namespace Sams\Manager;

class OutputEditManager extends BaseManager {

  public function getRules() {
    $state = $this->entity->state;

    if (!$state) {
      $date = current_date();
      $date = rest_date('1', $date);
      $rules = [
        'type' => 'required|in:normal,pernot',
        'date_start' => 'required_if:type,pernot|date|after:'.$date,
        'date_end' => 'required_if:type,pernot|date',
        'info' => 'required'
      ];
    } else {
      $rules = [
        'info' => 'required'
      ];
    }

    return $rules;
  }

}