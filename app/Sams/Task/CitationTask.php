<?php

namespace Sams\Task;

use Sams\Repository\CitationRepository;

class CitationTask extends BaseTask {
	
	protected $citationRepo;

	public function __construct(CitationRepository $citationRepo) {
		$this->citationRepo = $citationRepo;
	}

	public function confirmHour($date, $hour) {
		$currentDate = current_date();
		$currentHour = current_hour();

		if ($currentDate == $date) {
			if ($hour <= $currentHour) {
				$message = 'Hora ya paso';

				$this->hasException($message);
			}
		}
	}

	public function hourInterval($elder, $hour, $date) {
		$minutes = '59';
		$hourBefore = rest_minutes($hour, $minutes);
		$hourAfter = add_hour($hour, $minutes);
		$citation = $elder
			          	->citations()
				          	->where('date_day', $date)
										->where('hour','>', $hourBefore)
			  						->where('hour', '<', $hour)
		   							->orWhere(function ($query) use ($date, $hour, $hourAfter) {
		    	 							$query
		    	 								->where('date_day', $date)
			      							->where('hour', '>', $hour)
			      							->where('hour', '<=', $hourAfter);
		    						});

		if ($citation->count() > 0) {
			$citation = $citation->first();
			$message = 'Adulto mayor posee cita para las '.$citation->hour. ' de ese dia, citas deben tener una hora de diferencia';

			$this->hasException($message);
		}
	
	}

	public function getCurrentCitations() {
		$date = current_date();
		$hour = current_hour();
		$minutes = '60';
		$hourExpected = add_hour($hour, $minutes);
    $hourAfter = add_hour($hourExpected, $minutes);
    $citations = $this->citationRepo->getCitationsCurrent($date, $hourExpected, $hourAfter);
    
    if ($citations->count() == 0) {
    	$message = 'No hay citas pendientes en este momento';

    	$this->hasException($message);
    }

    $citations = $citations->get();

    return $citations;
	}

	public function getElderCitations($elder) {
		$citations = $elder->citations();

		if ($citations->count() == 0) {
			$message = 'Adulto mayor no tiene citas asignadas';

			$this->hasException($message);
		}

		$citations = $citations->get();

		return $citations;
	}

	public function confirmedCitation($citation, $state) {
		$date = current_date();
		$citationDate = $citation->date_day;

		if ($date < $citationDate) {
			$message = 'No pueden confirmar cita antes de la fecha asignada';

			$this->hasException($message);
		}

		if ($state) {
			$message = 'Cita confirmada';
			$citation->state = 'confirmed';
		} else {
			$message = 'Cita cancelada';
			$citation->state = 'reject';
		}

		$citation->save();

		$response = [
			'status' => 'success',
			'message' => $message
		];

		return $response;
	}

}