<?php

namespace Sams\Task;

class OccasionTask extends BaseTask {

  public function confirmOccasion($data) {
    $dateIn = $data['date_start'];
    $dateOut = $data['date_end'];
    $timeIn = $data['entry_time'];
    $timeOut = $data['departure_time'];

    if (!empty($dateOut)) {
      $this->confirmDate($dateIn, $dateOut);
    } else {
      if (!empty($timeOut)) {
        $this->confirmHour($timeIn, $timeOut);
      }
    }
  }

  public function confirmDate($dateIn, $dateOut) {
    if ($dateIn >= $dateOut) {
      $message = '"Fecha de inicio deber ser menor a fecha de fin"';

      $this->hasException($message);
    }
  }

  public function confirmHour($timeIn, $timeOut) {
    if ($timeIn >= $timeOut) {
      $message = '"Hora de inicio debe ser menor a hora de fin"';

      $this->hasException($message);
    }
  }

  public function confirmOccasionForDate($occasions) {
    if ($occasions->count() == 0) {
      $message = 'No hay eventos para esta fecha';

      $this->hasException($message);
    }

    $occasions = $occasions->get();

    return $occasions;
  }

  public function validateDate($date) {
    $date = ['date' => $date];
    $rules = ['date' => 'required|date'];
    $messages = [
      'date.required' => 'Ingrese fecha',
      'date.date' => 'Ingrese formato de fecha valido'
    ];

    $validator = \Validator::make($date, $rules, $messages);

    if ($validator->fails()) {
      $message = $validator->messages();

      $this->hasException($message);
    }
  }


}