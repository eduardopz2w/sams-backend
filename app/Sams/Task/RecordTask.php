<?php

namespace Sams\Task;
use Sams\Repository\RecordRepository;

class RecordTask extends BaseTask {

	protected $recordRepo;

	public function __construct(RecordRepository $recordRepo)

	{
			$this->recordRepo = $recordRepo;
	}


	public function recordCurrentConfirmed($id)

	{
			$recordCurrent = $this->recordRepo->getRecordCurrent($id);

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
						  $message = 'Adulto mayor con historia vigente';
							$this->hasException($message);
							
					}

			}
	}

	public function dateExpired($date)

	{
			$dateCurrent       = current_date();
			$timeStampCurrent  = $this->converToTimeStamp($dateCurrent);
			$timeStampDate     = $this->converToTimeStamp($date);
			$secondsDifference = $timeStampCurrent - $timeStampDate;
			$daysDifference    = $secondsDifference / (60 * 60 * 24);

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