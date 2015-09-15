<?php

namespace Sams\Manager;

class ActionEditManager extends BaseManager {

  public function getRules() {
    $rules = [
      'name' => 'required|regex:/^[\pL\s]+$/u|unique:actions,name,'.$this->entity->id,
    ];

    return $rules;
  }

}