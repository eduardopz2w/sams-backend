<?php

namespace Sams\Manager;

class OccurrenceEditManager extends BaseManager {
  public function getRules() {
    $rules = [
      'case_situation' => 'required',
      'date' => 'required|date'
    ];

    return $rules;
  }

}