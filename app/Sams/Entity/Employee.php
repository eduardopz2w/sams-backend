<?php

namespace Sams\Entity;

class Employee extends \Eloquent {
	protected $fillable = ['identity_card', 'first_name', 'last_name', 'date_birth',
	                       'phone', 'address', 'gender', 'degree_instruction', 'civil_status',
	                       'office', 'image_url', 'mime', 'activiti'];

	public function schedules()

	{
			return $this->belongsToMany('Sams\Entity\Schedule');
	}

	public function permits()

	{
			return $this->hasMany('Sams\Entity\Permit');
	}
}