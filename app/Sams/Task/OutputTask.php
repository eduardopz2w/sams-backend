<?php

namespace Sams\Task;

use Sams\Repository\OutputRepository;

class OutputTask extends BaseTask {

	protected $outputRepo;

	public function __construct( OutputRepository $outputRepo) {
		$this->outputRepo = $outputRepo;

	}

	public function hasOutput($elder) {
		$output = $elder->outputs()->where('state', 0);

		if ($output->count() > 0) {
			$message = 'Adulto mayor posee salida sin confirmar';

			$this->hasException($message);
		}
	}

	public function confirmedDate($data) {
		$type = $data['type'];

		if ($type == 'pernot') {
			$dateIn = $data['date_start'];
			$dateOut = $data['date_end'];

			if ($dateIn >= $dateOut) {
				$message = 'Fecha de inicio debe ser menor a fecha de llegada';

				$this->hasException($message);
			}
		}
	}
		

}