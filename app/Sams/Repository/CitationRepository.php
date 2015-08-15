<?php

namespace Sams\Repository;

use Sams\Entity\Citation;

class CitationRepository extends BaseRepository {

	public function getModel()

	{
			return new Citation;
	}

	public function getCitationsDate($date)

	{
			 return Citation::join('elders', 'citations.elder_id', '=', 'elders.id')
             					->select('citations.address', 'citations.date_day','citations.hour',
             	                 'citations.state','citations.reason',
             	                 'elders.full_name','elders.identity_card')
             		       ->where('date_day', $date);
	}

	public function getCitationsCurrent()

	{
		  $date         = current_date();
		  $minutes      = '60';
	 		$hour         = date('H:i');
	 		$hourExpected = add_hour($hour, $minutes);
	 		$hourAfter    = add_hour($hourExpected, $minutes);

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
             					->orWhere(function ($q) use ($date, $hourExpected) {
             							 $q->where('date_day', $date)
             							   ->where('hour', '<', $hourExpected)
             							   ->where('state', 'loading');
             					});
	}
	
	public function hourInterval($idElder, $hour, $hourBefore, $hourAfter, $date)

	{
			 return Citation::where('elder_id', $idElder)
			               		->where('date_day', $date)
			                  ->where('hour','>', $hourBefore)
			                  ->where('hour', '<=', $hour)
			                  ->orWhere(function ($q) use ($date, $hour, $hourAfter) {
			                  		$q->where('date_day', $date)
			                  		  ->where('hour', '>', $hour)
			                  		  ->where('hour', '<=', $hourAfter);
			                  });
	}

}