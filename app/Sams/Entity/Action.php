<?php

namespace Sams\Entity;

class Action extends \Eloquent {
	protected $fillable = ['name','description', 'state'];

	public function schedules() {
	  return $this->belongsToMany('Sams\Entity\Schedule')->withTimestamps();
	}
	
}