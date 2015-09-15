<?php

namespace Sams\Task;

use Sams\Repository\ActionRepository;
use Sams\Repository\ScheduleRepository;

class ActionTask extends BaseTask {
	 
	protected $actionRepo;
	protected $scheduleRepo;
  protected $attendanceTask;

	public function __construct(ActionRepository $actionRepo, 
		                          ScheduleRepository $scheduleRepo,
                              AttendanceTask $attendanceTask) {
		$this->actionRepo = $actionRepo;
		$this->scheduleRepo = $scheduleRepo;
    $this->attendanceTask = $attendanceTask;
	}

  public function actionState($action) {
    $state = $action->state;

    if ($state) {
      $message = 'Actividad ya no sera realizada';
      $action->state = 0;
    } else {
      $message = 'Actividad vigente';
      $action->state = 1;
    }

    $action->save();

    $response = [
     'status' => 'success',
     'message' => $message
    ];

    return $response;
  }

  public function getActions() {
    $actions = $this->actionRepo->getActions();

    if ($actions->count() == 0) {
      $message = 'No hay actividades registradas';

      $this->hasException($message);
    }

    return $actions;
  }


  public function getForDay() {
    $date = current_date();
    $day = date_day($date);
    $schedules = $this->scheduleRepo->scheduleInActionDay($day);
    $actionsContent = [];
    
    if ($schedules->count() > 0) {
      $schedules = $schedules->get();

      $this->actionForSchedule($schedules, $actionsContent, $date);
    }

    if (count($actionsContent) == 0) {
      $message = 'No hay actividades para este dia';

      $this->hasException($message);
    }

    return $actionsContent;
  }

  public function actionForSchedule($schedules, &$actionsContent, $date) {
    foreach ($schedules as $schedule) {
      $actions = $schedule->actions;

      foreach ($actions as $action) {
        $assingSchedule = $action->pivot->created_at;
        $actionInDate = $this->attendanceTask->entityInDate($assingSchedule , $date);
        $state = $action->state;
        
        if ($state && $actionInDate) {
          $action->hour_in  = $schedule->entry_time;
          $action->hour_out = $schedule->departure_time;

          array_push($actionsContent, $action);
        }
      }
    }
  }

		 
}