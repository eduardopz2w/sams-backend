<?php

namespace Sams\Manager;

class RecordEditManager extends BaseManager {
  
  public function getRules() {
    $rules = [
      'size_diaper'=> 'in:S,M,L,No aplica',
      'baston'  => 'in:1 point,3 point, 4 point,No aplica',
      'index_katz' => 'required',
      'index_lawtonbrody'  => 'required',
      'disability_physical'=> 'required',
      'disability_psychic' => 'required'
    ];

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'size_diaper.in' => 'Talla de pañal ingresada es inválido',
      'baston.in' => 'Tipo de baston ingresado es inválido',
      'index_katz.required' => 'Ingrese indice de katz',
      'index_lawtonbrody.required' => 'Ingrese indice de lawtonbrody',
      'disability_physical.required' => 'Ingrese indice de capacidad fisica',
      'disability_psychic.required' => 'Ingrese indice de capacidad psiquica'
    ];

    return $messages;
  }
}