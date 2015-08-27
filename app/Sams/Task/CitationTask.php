<?php

namespace Sams\Task;

use Sams\Repository\CitationRepository;

class CitationTask extends BaseTask {
	
	protected $citationRepo;

	public function __construct(CitationRepository $citationRepo)

	{
			$this->citationRepo = $citationRepo;
	}

	public function hourInterval($idElder, $hour, $date)

	{
			$minutes    = '59';
			$hourBefore = rest_minutes($hour, $minutes);
			$hourAfter  = add_hour($hour, $minutes);
			
			$interval = $this->citationRepo->hourInterval($idElder, $hour, $hourBefore, $hourAfter, $date);

			if ($interval->count() > 0)

			{
					$citation = $interval->first();
					$message  = 'El adulto mayor posee cita para las '.$citation->hour_usual. ' debe existir 1 hora de diferencia entre citas';

					$this->hasException($message);
			}
	}

	public function stateCitation($citation, $confirmed, $notification)

	{
			
		  $message = 'Constancia medica guardada';

			if ($confirmed)

			{
				  if (!$notification) $message = 'Cita confirmada';

					$citation->state = 'done';
			}

			elseif (!$confirmed)

			{
				  $message  = 'Cita no realizada';
					$citation->state = 'fail';
			}

			$citation->save();
			return $message;
	}

	public function citationConfirmed($citation)

	{
			$date = current_date();
			$dateCitation = $citation->date_day;

			if ($dateCitation > $date)

			{
					$message = 'Fecha de cita  no ha transcurrido';
					$this->hasException($message);
			}

		  $reference = $citation->reference;

			$this->hasReference($reference);
	}

	public function hasReference($reference)

	{
			if ($reference)

			{
					$message = 'Cita ya posee constancia';
					$this->hasException($message);
			}
	}

	public function citationConfirmedDate($citations)

	{
			if ($citations->count() == 0)

			{
					$message = 'No hay citas registradas para esta fecha';
					$this->hasException($message);
			}

			$citations = $citations->get();

			// $this->langState($citations);
			return $citations;
	}

	// public function langState(&$citations)

	// {
	// 		foreach ($citations as $citation) 

	// 		{
	// 			  $stateLang = $citation->state_entry;
	// 			  $citation->state = $stateLang;
	// 		}
	// }

	public function citationConfirmHour()

	{
	  $citations = $this->citationRepo->citationsCurrent();

		if ($citations->count() == 0)

		{
		  $message = 'No hay citas para este momento';
			$this->hasException($message);
		}

		$citations = $citations->get();
			
		return $citations;
		
  }

}