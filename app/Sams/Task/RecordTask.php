<?php

namespace Sams\Task;
use Sams\Manager\ImageRecordManager;
use Sams\Repository\RecordRepository;

class RecordTask extends BaseTask {

	protected $recordRepo;

	public function __construct(RecordRepository $recordRepo)

	{
	  $this->recordRepo = $recordRepo;
	}


	public function recordCurrentChangeState($id)

	{
	  $recordCurrent = $this->recordRepo->recordCurrent($id);

		if ($recordCurrent->count() > 0)

		{	
			$record = $recordCurrent->first();
		  $record->state = 0;
		  $record->save();
		}
	}

	public function addImg($record, $img, $mime)

	{
	  $imgRecord = new ImageRecordManager($record, $img, $mime);
	  $imgRecord->uploadImg();
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
		  return false;
		}

	  return true;
	}

	public function converToTimeStamp($date)

	{
	  $segmentsDate = explode('-', $date);
	  $segmentMonth  = explode(' ', $segmentsDate[2]);
			
	  return mktime(0, 0, 0, $segmentsDate[1], $segmentMonth[0], $segmentsDate[0]);
	}

}