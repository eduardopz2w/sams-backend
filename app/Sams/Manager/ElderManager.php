<?php

namespace Sams\Manager;

class ElderManager extends BaseManager {

  public function getRules()

  {
    $rules = [
      'identity_card' => 'required|numeric|unique:elders,identity_card,'. $this->entity->id,
      'full_name'     => 'required|regex:/^[\pL\s]+$/u',
      'address'       => 'required',
      'gender'        => 'required',
      'civil_status'  => 'required|in:single,married',
      'date_birth'    => 'required|date'
    ];
    
    return $rules;
  }
  public function prepareData($data)

  {
    $this->isRetired($data);
    $this->isPensioner($data);
    return $data;
  }

  public function isRetired(&$data)

  {
    if (!isset($data['retired']))

    {
      $data['retired'] = 0;
    }

    else

    {
      $data['retired'] = 1;
    }
  }

  public function isPensioner(&$data)

  {
    if (!isset($data['pensioner']))

    {
      $data['pensioner'] = 0;
    }

    else
    {
      $data['pensioner'] = 1;
    }
  }
}