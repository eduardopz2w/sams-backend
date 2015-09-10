<?php

namespace Sams\Repository;

use Sams\Entity\Occasion;

class OccasionRepository extends BaseRepository {

  public function getModel() {
    return new Occasion;
  }

  public function getForDate($date) {
    return Occasion::where('date_start', $date)
                   ->orWhere(function ($q) use ($date) {
                      $q->where('date_start', '<=', $date)
                        ->where('date_end', '>=', $date);
                   });
  }

}