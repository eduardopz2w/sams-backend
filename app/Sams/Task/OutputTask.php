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
				$message = 'Fecha de salida debe ser menor que fecha de llegada';

				$this->hasException($message);
			}
		}
	}

	public function confirmed($output) {
		$output->state = 1;

		$output->save();
	}

	public function getOutputType($type) {
		if ($type == 'pernot') {
			$date = current_date();
			$message = 'No hay adultos con salida del tipo pernocta';
			$outputs = $this->outputRepo->getOutputPernot($date);
		} else {
			$message = 'No hay salidas por confirmar';
			$outputs = $this->outputRepo->getOutputNormal();
		}

		if ($outputs->count() == 0) {
			$this->hasException($message);
		}
    
    $outputs = $outputs->get();
		
		return $outputs;
	}

	public function getOutputElder($elder) {
		$outputs = $elder->outputs();

		if ($outputs->count() == 0) {
			$message = 'Adulto mayor no posee registros de salidas';

			$this->hasException($message);
		}

		$outputs = $outputs->get();

		return $outputs;
	}

	public function getOutputWaiting() {
		$date = current_date();
		$outputs = $this->outputRepo->getOutputPernotWaiting($date);

		if ($outputs->count() == 0) {
			$message = 'No se espera la de llegada de adultos mayores';

			$this->hasException($message);
		}

		$outputs = $outputs->get();

		return $outputs;
	}
		
}