<?php

namespace Sams\Entity;

class Elder extends \Eloquent {
	protected $fillable = ['identity_card', 'full_name'];

	public function instances()

	{
			return $this->hasMany('Sams\Entity\Instance');
	}
}