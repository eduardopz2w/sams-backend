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

	public function occurrences()

	{
			return $this->hasMany('Sams\Entity\Occurrence');
	}

	public function citations()

	{
			return $this->hasMany('Sams\Entity\Citation');
	}

	public function reference()

	{
			return $this->hasOne('Sams\Entity\Reference');
	}
}