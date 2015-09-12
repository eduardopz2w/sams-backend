<?php

namespace Sams\Repository;

use Sams\Entity\Output;

class OutputRepository extends BaseRepository {

	public function getModel() {
	  return new Output;
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