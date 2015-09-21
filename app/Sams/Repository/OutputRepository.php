<?php

namespace Sams\Repository;

use Sams\Entity\Output;

class OutputRepository extends BaseRepository {

	public function getModel() {
	  return new Output;
	}

	public function getOutputPernot($date) {
		return Output::join('elders', 'outputs.elder_id', '=', 'elders.id')
		              ->select('elders.full_name',
		              		'elders.identity_card',
		              		'outputs.id',
		              		'outputs.elder_id',
		              		'outputs.date_start',
		              		'outputs.date_end'
		              	)
		             	->where('type', 'pernot')
		             	->where('date_start', '<=', $date)
		              ->where('state', 0);
		              
	}

	public function getOutputPernotWaiting($date) {
		return Output::join('elders', 'outputs.elder_id', '=', 'elders.id')
		              ->select('elders.full_name',
		              		'elders.identity_card',
		              		'outputs.id',
		              		'outputs.elder_id',
		              		'outputs.date_start',
		              		'outputs.date_end'
		              	)
		             	->where('type', 'pernot')
		             	->where('date_end', '<=', $date)
		              ->where('state', 0);
	}

	public function getOutputNormal() {
		return Output::join('elders', 'outputs.elder_id', '=', 'elders.id')
		              ->select('elders.full_name',
		              	 'elders.identity_card',
		              	 'outputs.id',
		              	 'outputs.elder_id',
		              	 'outputs.created_at'
		               )
		              ->where('type', 'normal')
		              ->where('state', 0);
	}
	

	// public function hasElderOutput($elderId)

	// {
	// 		return Output::where('elder_id', $elderId)
	// 		             ->where('state', 1);
	// }

	// public function hasEmployeeOutput($employeeId)

	// {
	// 		return Output::where('employee_id', $employeeId)
	// 		             ->where('state', 1);
	// }

	// public function getOutputsTimeLimit()

	// {
	// 	  $date = current_date();
	// 		return Output::where('date_end', '<=', $date)
	// 		             ->where('state', 1);
	// }

}