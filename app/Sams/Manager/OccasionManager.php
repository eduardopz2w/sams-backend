<?php

namespace Sams\Manager;

class OccasionManager extends BaseManager {

  public function getRules() {
    $date = current_date();
    $day = 1;
    $date = rest_date($day, $date);

    $rules = [
     'name' => 'required|regex:/^[\pL\s]+$/u',
     'date_start' => 'required|date|after:'.$date,
     'date_end' => 'date',
     'entry_time' => 'date_format:H:i',
     'departure_time' => 'date_format:H:i'
    ];

    return $rules;
  }

  public function prepareData($data) {
    $times = array_only($data, ['entry_time', 'departure_time', 'date_end']);
    $nameTimes = array_keys($times);
    $valueTimes = array_values($times);

    for ($i = 0; $i < count($valueTimes); $i ++) {
      $value = $valueTimes[$i];

      if (empty($value)) {
        $key = $nameTimes[$i];
        $data[$key] = NULL;
      }
    }

    return $data;
  }

}