<?php

namespace Sams\Repository;

abstract class BaseRepository{
	
	protected $model;

	public function __construct()

	{
			$this->model = $this->getModel();
	}

	abstract public function getModel();

	public function find($id)

	{
			return $this->model->find($id);
	}

}