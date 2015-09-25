<?php

namespace Sams\Task;

use Sams\Manager\ImageOccurrenceManager;

class OccurrenceTask extends BaseTask {
  
  public function addImg($occurrence, $img, $mime) {
    $imgRecord = new ImageOccurrenceManager($occurrence, $img, $mime);

    $imgRecord->uploadImg();
  }

  public function getOccurrences($elder) {
    $occurrences = $elder
                    ->occurrences()
                      ->orderBy('date', 'DESC');

    if ($occurrences->count() == 0) {
      $message = 'Adulto mayor no posee incidencias';

      $this->hasException($message);
    }

    $occurrences = $occurrences->get();

    return $occurrences;
  }

}