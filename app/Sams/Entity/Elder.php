<?php

namespace Sams\Entity;

class Elder extends \Eloquent {
	protected $fillable = ['identity_card', 'full_name', 'address', 'gender',
	                       'retired', 'pensioner', 'civil_status'];

	public function instances()

	{
			return $this->hasMany('Sams\Entity\Instance');
	}

	public function records()

	{
			return $this->hasMany('Sams\Entity\Record');
	}

	public function getInstanceWaiting()

	{
			return $this->instances()->where('state', 'waiting');
	}
}