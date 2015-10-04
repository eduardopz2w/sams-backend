<?php

namespace Sams\Manager;

class EmployeeEditManager extends BaseManager {
  
  public function getRules() {
    $rules = [
      'identity_card' => 'required|numeric|unique:employees,identity_card,'.$this->entity->id,
      'address' => 'required',
      'full_name' => 'required|regex:/^[\pL\s]+$/u',
      'date_birth' => 'required|date',
      'phone'  => 'numeric',
      'gender' => 'required',
      'degree_instruction' => 'required|in:none,primary,secondary,university',
      'civil_status' => 'required|in:married,single',
      'office'  => 'required'
    ];

    return $rules;
  }

  public function prepareData($data) {
    if (isset($data['activiti'])) {
      $data['activiti'] = 1;
    } else {
      $data['activiti'] = 0;
    }

    return $data;
  }
    


}