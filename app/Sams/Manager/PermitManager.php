<?php

namespace Sams\Manager;

class PermitManager extends BaseManager {
  public function getRules() {
    $day = current_date();
    $rules = [
      'reason' => 'required',
      'turn' => 'required_if:type,normal|in:morning,afternoon,night,complete',
      'type' => 'required|in:extend,normal',
      'date_start' => 'required|date|after:'.$day,
      'date_end' => 'required_if:type,extend|date'
    ];

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'reason.required' => 'Ingrese motivo',
      'turn.required_if' => 'Ingrese turno',
      'type.required' => 'Tipo de permiso es requerido',
      'type.in' => 'Tipo de permiso es inválido',
      'date_start.required' => 'Ingrese fecha de inicio',
      'date_start.date' => 'Ingrese formato valido para fecha de inicio',
      'date_start.after' => 'Fecha ya pasado',
      'date_end.required_if' => 'Ingrese fecha de finalizacion',
      'date_end.date' => 'Ingrese formato valido para fecha de finalizacion'
    ];

    return $messages;
  }

  public function prepareData($data) {
    $data['state'] = 'espera';

    return $data;
  }

}

 