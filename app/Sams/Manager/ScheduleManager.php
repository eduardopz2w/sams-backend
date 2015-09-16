<?php

namespace Sams\Manager;


class ScheduleManager extends BaseManager {

	public function validateSchedule($timeBreak)

	{
	  $data = $this->data;
	  $this->isValid();
		$this->confirmHours($data, $timeBreak);
		$this->confirmDays($data);
	}

	public function getRules()

	{
	  $rules = ['entry_time'  => 'required|date_format:H:i',
			        'departure_time' => 'required|date_format:H:i'];
			          
		return $rules;
	}

	public function confirmHours($data, $timeBreak)

	{
	  $hourNoon      = '12:00';
	  $hourAfternoon = '14:00';
	  $hourNight     = '17:00';
    $hourIntro     = $data['entry_time'];
    $hourOutput    = $data['departure_time'];

		if ($hourIntro >= $hourOutput && $hourIntro < $hourNight || $hourIntro == $hourOutput)

		{
		  $message = 'Ingrese horas correctamente';
		  $this->hasError($message);
		}

		if ($hourIntro < $hourNoon && $hourOutput > $hourAfternoon && $timeBreak)

		{
		  $this->differenceHoursTurn($hourIntro, $hourOutput);
		}

		else

		{
		  $this->differenceHours($hourIntro, $hourOutput);
		}

	}

	public function differenceHoursTurn($hourIntro, $hourOutput)

	{
	  $hourIn          = $this->hourFormat($hourIntro);
	  $hourNoon        = $this->hourFormat('12:00');
	  $hourOut         = $this->hourFormat($hourOutput);
	  $hourAfternoon   = $this->hourFormat('14:00');

	  $hourTurnMorning = $this->hourTotal($hourIn, $hourNoon);
		$hourTurnAfter   = $this->hourTotal($hourAfternoon, $hourOut);

		$hourTotal = $hourTurnMorning + $hourTurnAfter;

		$this->hourMax($hourTotal);
	}

	public function differenceHours($hourIntro, $hourOutput)

	{
	  $hourNight = '17:00';
		$hourIn    = $this->hourFormat($hourIntro);
		$hourOut   = $this->hourFormat($hourOutput);

		if ($hourIntro >= $hourNight && $hourOutput < $hourNight)

		{
		  $midNight  = $this->hourFormat('24:00');
		  $hourEarly = $midNight + $hourOut;
		  $hourTotal = $this->hourTotal($hourEarly, $hourIn);
				
		}

		else

		{
		  $hourTotal = $this->hourTotal($hourIn,$hourOut);
		}

		$maxMin = 59;
     
    $this->ourMin($hourTotal);

		if ($hourTotal > $maxMin)

		{
		  $this->hourMax($hourTotal);
		}
	}

	public function ourMin($hourTotal)

	{
	  $conf = get_configuration();
    $hourOutMin = $conf->min_time;
    $minDuration = $hourOutMin. ' minutos';
    $minutesComparation = 59;


		if ($hourOutMin > $minutesComparation)

		{
		  $minDuration = $hourOutMin / 60;
		  $minDuration = $minDuration.' horas';
		}

		if ($hourTotal < $hourOutMin) 

		{
		  $message = 'Horarios deben tener duracion de almenos '.$minDuration;
		  $this->hasError($message);
		}
	}

	public function hourTotal($hourIn, $hourOut)

	{
	  $hourTotal = $hourOut - $hourIn;
	  return abs($hourTotal);

	}

	public function hourFormat($hour)

	{
	  $time   = explode(':', $hour);
	  return $elapse = ($time[0] * 60) + $time[1];

	}

	public function hourMax($hourTotal)

	{
	  $configuration = get_configuration();
	  $maxHours      = $configuration->max_hours;
	  $hourElapse    = round($hourTotal / 60);
    $hourElapse    = $this->oneDigit($hourElapse);
	  $minuteElapse  = $hourTotal % 60;
	  $minuteElapse  = $this->oneDigit($minuteElapse);
	  $hourWorking   = $hourElapse.':'.$minuteElapse;

		if ($hourWorking > $maxHours)

		{
		  $message = 'maximo de tiempo de trabajo '. $maxHours;
	    $this->hasError($message);
		}

	}

	public function oneDigit($time)

	{
	  $digit = 9;

		if ($time <= $digit) 

		{
		  return '0'.$time;
		}

		return $time;
	}

	public function confirmDays($data)

	{
	  $days = array_only($data, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday',
				                       'saturday', 'sunday']);
      
    $values = array_values($days);
    $days = array_keys($days);
		$first = true;
		$selectDays = '';

		for ($i = 0; $i < count($days); $i++)

		{
		  if (!empty($values[$i]))

			{
			  if ($first)

				{
				  $first = false;
				  $selectDays = $days[$i];
				}

				else

				{
				  $selectDays .= ' '.$days[$i];
			  }
			}

		}

		$this->validDays($selectDays);
	}

	public function validDays($selectDays)

	{
	  if (!empty($selectDays))

		{
		  $this->selectDays = $selectDays;
		}

		else

		{
		  $message = 'Dias son requeridos';
	    $this->hasError($message);
		}
	}

	public function getDays()

	{
	  return $this->selectDays;
	}

	public function prepareData($data)

	{
	  $data['days'] = $this->getDays(); 
	  return $data;
	}

	public function hasError($message)

	{
	  throw new ValidationException("Error Processing Request", $message);
	}


}