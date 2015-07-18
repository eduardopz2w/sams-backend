<?php

namespace Sams\Task;

use Sams\Manager\ValidationException;

class RecordTask {

	public function recordCurrentConfirmed($recordCurrent)

	{
			if ($recordCurrent->count() > 0)

			{
					$record = $recordCurrent->first();

					if ($this->dateExpired($record->created_at))

					{
							$record->state = 0;
							$record->save();
					}

					else

					{
							throw new ValidationException("Error Processing Request", 'Adulto mayor con historia vigente');
							
					}

			}
	}

	public function dateExpired($date)

	{
			$dateCurrent = current_date();
			$timeStampCurrent = $this->converToTimeStamp($dateCurrent);
			$timeStampDate = $this->converToTimeStamp($date);

			$secondsDifference = $timeStampCurrent - $timeStampDate;
			$daysDifference = $secondsDifference / (60 * 60 * 24);

			if ($daysDifference >= 365)

			{
				 return true;
			}

			return false;
	}

	public function converToTimeStamp($date)

	{
			$segmentsDate = explode('-', $date);
			$segmentMonth  = explode(' ', $segmentsDate[2]);
			
			return mktime(0, 0, 0, $segmentsDate[1], $segmentMonth[0], $segmentsDate[0]);
	}

}