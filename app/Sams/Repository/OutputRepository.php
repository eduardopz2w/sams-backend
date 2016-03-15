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
		              ->where('date_start', '<=', $date)
		             	->where('type', 'pernot')
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
	

}