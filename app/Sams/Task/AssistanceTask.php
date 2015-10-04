<?php

namespace Sams\Task;

use Sams\Repository\AttendanceRepository;

class AssistanceTask extends BaseTask {
  protected $attendanceRepo;

  public function __construct(AttendanceRepository $attendanceRepo) {
    $this->attendanceRepo = $attendanceRepo;
  }

  public function confirmedAssitance($attendance, $state) {
    $hour = $this->getHour();

    if ($state) {
      $scheduleIn = $attendance->start_time;

      $this->confirmHourIn($hour, $scheduleIn);

      $attendance->hour_in = $hour;
      $attendance->state = 'E';
      $message = 'Entrada confirmada';
    } else {
      $attendance->hour_out = $hour;
      $attendance->state = 'A';
      $message = 'Salida confirmada';
    }

    $attendance->save();

    $response = [
      'status' => 'success',
      'message' => $message
    ];

    return $response;
  }

  public function statusEmployee($employeeState) {
    if (!$employeeState) {
      $message = 'Empleado no activo su asistencia no podra ser modificada';

      $this->hasException($message);
    }
  }

  public function checkAssistance($data, $employee, $attendance) {
    $scheduleIn = $attendance->start_time;
    $scheduleOut = $attendance->departure_time;
    $turn = $attendance->turn;

    if ($turn != 'night') {
      $hourIn = $data['hour_in'];
      $hourOut = $data['hour_out'];

      if ($hourIn >= $hourOut) {
        $message = 'Ingrese horas en el orden correcto';

        $this->hasException($message);
      }

      $this->checkHourIn($hourIn, $scheduleOut);
      $this->checkHourOut($hourOut, $hourIn, $employee);
    }
   
  }

  public function confirmHourIn($hourIn, $scheduleIn) {
    $scheduleMin = '01:00:00';

    if ($scheduleIn >= $scheduleMin) {
      $minutes = '15';
      $hourMin = rest_minutes($scheduleIn, $minutes);

      if ($hourIn < $hourMin) {
        $message = '"Aun falta para que empieze el horario"';

        $this->hasException($message);
      }
    }
    
  }

  public function checkHourIn($hourIn, $scheduleOut) {
    if ($hourIn >= $scheduleOut) {
      $message = 'Ingrese hora de entrada antes que termina el horario';

      $this->hasException($message);
    }
  }

  public function checkHourOut($hourOut, $hourIn, $employee) {
    $date = current_date();
    $checkOut = $employee
                  ->attendances()
                    ->where('start_time','>', $hourIn)
                    ->where('start_time', '<=', $hourOut)
                    ->where('date_day', $date);

    if ($checkOut->count() > 0) {
      $message = 'Hora de salida interfiere con hora de entrada de otro horario';

      $this->hasException($message);
    }
  }

  public function getAssistanceForEmploye($employee) {
    $attendances = $employee
                     ->attendances()
                      ->where('state', '<>', 'E');

    if ($attendances->count() == 0) {
      $message = 'Empleado no posee asistencias';

      $this->hasException($message);
    }

    $attendances = $attendances->get();

    return $attendances;
  }

  public function getHour() {
    $hour = current_hour();

    return $hour;
  }

}
