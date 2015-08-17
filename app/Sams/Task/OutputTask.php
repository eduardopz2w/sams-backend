<?php

namespace Sams\Task;

use Sams\Repository\RelativeRepository;
use Sams\Repository\OutputRepository;

class OutputTask extends BaseTask {

	protected $relativeRepo;
	protected $outputRepo;
	protected $elderTask;
	protected $employeeTask;

	public function __construct(RelativeRepository $relativeRepo, OutputRepository $outputRepo,
		                          ElderTask $elderTask, EmployeeTask $employeeTask)

	{
		  $this->relativeRepo = $relativeRepo;
		  $this->outputRepo   = $outputRepo;
			$this->elderTask    = $elderTask;
			$this->employeeTask = $employeeTask;
	}

	public function elderConfimed(&$data)

	{
		  $identify = array_pull($data ,'identiy_card');
		  $elder  = $this->elderTask->findElderByCredential($identify);
		  $this->hasElderOutput($elder->id);
		  $data = array_add($data, 'elder_id', $elder->id);
	}


	public function addAcompanit($output, $accompanist)

	{
			if ($accompanist)

			{
					$accompanist->outputs()->save($output);
			}
	}

	public function accompanistConfirm($data)

	{
		  if (!empty($data['accompanist']))

		  {
		  		$response = $this->getAccompanist($data);
		  }

		  else

		  {
		  		$response = false;
		  }
		  return $response;
	}

	public function getAccompanist($data)

	{
		  $identityCard = $data['accompanist'];
		  $idElder      = $data['elder_id'];

			if ($data['type'] == 'normal')

			{
					$accompanist = $this->employeeConfirmed($identityCard);
			}

			else
			
			{
					$accompanist = $this->relativeConfirmed($identityCard, $idElder);
			}

			return $accompanist;
	}

	public function employeeConfirmed($identityCard)

	{
			$employee = $this->employeeTask->findEmployeeByCredentials($identityCard);
			$hasEmployeeOutput = $this->outputRepo->hasEmployeeOutput($employee->id);

			if ($hasEmployeeOutput->count() > 0)

			{
					$message = 'Empleado tiene salida sin confirmar';
					$this->hasException($message);
			}

			return $employee;
	}

	public function relativeConfirmed($identityCard, $idElder)

	{
			$relative = $this->relativeRepo->findrelativeForByIdentify($identityCard, $idElder);

			if ($relative->count() == 0)

			{
					$message = 'Pariente no encontrado, verifique e intente de nuevo';
					$this->hasException($message);
			}
	}

	public function hasElderOutput($idElder)

	{
			$hasElderOutput = $this->outputRepo->hasElderOutput($idElder);

			if ($hasElderOutput->count() > 0)

			{
					$message = 'Adulto mayor tiene salida sin confirmar';
					$this->hasException($message);
			}
	}

	public function confirmedDate($data)

	{
		  $dateIn  = $data['date_init'];
		  $dateEnd = $data['date_end'];
		  $type    = $data['type'];

		  if ($type == 'pernot')

		  {
		  		if ($dateIn > $dateEnd)

					{
						  $message = 'Fecha de salida no debe ser mayor a fecha de llegada';
						  $this->hasException($message);
					}
		  }
			
	}

}