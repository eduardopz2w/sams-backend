<?php

namespace Sams\Manager;

class RecordEditManager extends BaseManager {
  
  public function getRules() {
    $rules = [
      'size_diaper'=> 'in:S,M,L',
      'baston'  => 'in:1 point,3 point, 4 point',
      'index_katz' => 'required',
      'index_lawtonbrody'  => 'required',
      'disability_physical'=> 'required',
      'disability_psychic' => 'required'
    ];

    return $rules;
  }
}