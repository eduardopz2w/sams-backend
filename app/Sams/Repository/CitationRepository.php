<?php

namespace Sams\Repository;

use Sams\Entity\Citation;

class CitationRepository extends BaseRepository {

	public function getModel() {
	  return new Citation;
	}
	
	public function getCitationsCurrent($date, $hourExpected, $hourAfter) {
		return Citation::join('elders', 'citations.elder_id', '=', 'elders.id')
             			 	->select('citations.address',
             	        		 'citations.date_day',
             	             'citations.hour',
             	             'citations.reason',
             	             'elders.full_name',
             	             'elders.identity_card')
             				->where('date_day', $date)
             				->where('hour', '>=', $hourExpected)
             				->where('hour', '<', $hourAfter)
             				->where('state', 'loading')
             				->orWhere(function ($query) use ($date, $hourExpected) {
             						$query->where('date_day', $date)
             									->where('hour', '<', $hourExpected)
             									->where('state', 'loading');
             				 })
                  	->orderBy('hour', 'DESC');
	}


}