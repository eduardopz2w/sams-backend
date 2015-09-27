<?php

namespace Sams\Repository;

use Sams\Entity\Citation;

class CitationRepository extends BaseRepository {
  public function getModel() {
    return new Citation;
  }
	
  public function getCitationsCurrent($date) {
    return Citation::join('elders', 'citations.elder_id', '=', 'elders.id')
             	->select('citations.hour',
             	         'citations.reason',
                       'citations.id',
                       'citations.elder_id',
             	         'elders.full_name',
             	         'elders.identity_card'
                       
                          )
             		 ->where('date_day', $date)
             		 ->where('state', 'loading')
             		 ->orWhere(function ($query) use ($date) {
             		    $query->where('date_day', $date)
             		      ->where('state', 'loading');
             		 })
                 ->orderBy('hour', 'ASC');
  }


}