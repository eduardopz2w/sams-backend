<?php

namespace Sams\Manager;

class ElderManager extends BaseManager {

  public function getRules() {
    $rules = [
      'identity_card' => 'required|numeric|unique:elders,identity_card,'. $this->entity->id,
      'full_name' => 'required|regex:/^[\pL\s]+$/u',
      'address' => 'required',
      'gender' => 'required',
      'civil_status' => 'required|in:single,married',
      'date_birth' => 'required|date'
    ];
    
    return $rules;
  }

  public function getMessages() {
    $messages = [
      'identity_card.required' => 'Ingrese cedula',
      'identity_card.numeric' => 'Cedula debe ser un numero',
      'identity_card.unique' => 'Ya hay otro adulto mayor con esta cedula',
      'full_name.required'  => 'Ingrese nombre',
      'full_name.regex' => 'Ingrese formato de nombre valido',
      'address.required' => 'Ingrese direccion',
      'gender.required' => 'Ingrese genero',
      'civil_status.required' => 'Ingrese estado civil',
      'civil_status.in' => 'Estado civil que ha ingresado  es inválido',
      'date_birth.required' => 'Ingrese fecha de nacimiento',
      'date_birth.date' => 'Ingrese formato valido para fecha de nacimiento'
    ];

    return $messages;
  }
  
  public function prepareData($data) {
    if (!isset($data['retired'])) {
      $data['retired'] = 0;
    } else {
      $data['retired'] = 1;
    }

    if (!isset($data['pensioner'])) {
      $data['pensioner'] = 0;
    } else {
      $data['pensioner'] = 1;
    }

    return $data;
  }


}