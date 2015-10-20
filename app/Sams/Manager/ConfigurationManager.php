<?php

namespace Sams\Manager;

class ConfigurationManager extends BaseManager {

  public function getRules() {
    $rules = [
      'name_institution' => 'required',
      'max_hours' => 'required|date_format:H:i',
      'max_permits' => 'required|numeric',
      'max_impeachment' => 'required|numeric'
    ];

    return $rules;
  }

  public function getMessages() {
    $messages = [
      'name_institution.required' => 'Nombre de institucion es requerido',
      'max_hours.required' => 'Cantidad maxima de horas es requerido',
      'max_hours.date_format' => 'Ingrese formato correcto para asignar maxima cantidad de horas',
      'max_permits.required' => 'Cantidad maxima de permisos es requerido',
      'max_permits.numeric' => 'Cantidad maxima de permisos debe ser un numero',
      'max_impeachment.required' => 'Cantidad maxima de adultos residentes es requerido',
      'max.max_impeachment.numeric' => 'Cantidad maxima de adultos residentes es requerido'
    ];

    return $messages;
  }

}