<?php

namespace Sams\Manager;

class RelativeManager extends BaseManager {

	public function getRules()

	{
			$rules = [
				'identity_card'      => 'required|unique:relatives|min:6',
				'full_name'          => 'required|regex:/^[\pL\s]+$/u',
				'affective_relations' => 'required|regex:/^[\pL\s]+$/u',
				'phone'              => 'min:7'
			];

			return $rules;
	}

	public function prepareData($data)

	{
			array_pull($data, 'ident_elder');
			return $data;
	}

}