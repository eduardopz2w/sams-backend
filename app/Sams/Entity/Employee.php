<?php

namespace Sams\Entity;

class Employee extends \Eloquent {
	protected $fillable = ['identity_card', 'first_name', 'last_name', 'date_birth',
	                       'phone', 'address', 'gender', 'degree_instruction', 'civil_status',
	                       'office', 'image_url', 'mime', 'activiti', 'break_out'];

	public function schedules()

	{
			return $this->belongsToMany('Sams\Entity\Schedule')->withTimestamps();
	}

	public function attendances()

	{
			return $this->hasMany('Sams\Entity\Attendance');
	}

	public function actions()

	{
		  return $this->hasMany('Sams\Entity\Action');
	}

	public function permits()

	{
			return $this->hasMany('Sams\Entity\Permit');
	}

	public function outputs()

	{
			return $this->hasMany('Sams\Entity\Output');
	}
}