<?php

namespace Sams\Entity;

class Schedule extends \Eloquent {
	protected $fillable = ['entry_time', 'departure_time', 'days'];

	public function employees()

	{
			return $this->belongsToMany('Sams\Entity\Employee')->withTimestamps();
	}

	public function actions()

	{
			return $this->belongsToMany('Sams\Entity\Action')->withTimestamps();
	}

}