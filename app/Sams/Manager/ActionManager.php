<?php

namespace Sams\Manager;

class ActionManager extends BaseManager {

	public function getRules() {
		$rules = [
			'name' => 'required|regex:/^[\pL\s]+$/u|unique:actions,name',
		];

		return $rules;
	}

	public function prepareData($data) {
		$data['state'] = 1;

		return $data;
	}

}