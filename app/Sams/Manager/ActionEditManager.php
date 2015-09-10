<?php

namespace Sams\Manager;

class ActionEditManager extends BaseManager {

  public function getRules() {
    $rules = [
      'name' => 'required|regex:/^[\pL\s]+$/u|unique:actions,title,'.$this->entity->id,
    ];

    return $rules;
  }

}