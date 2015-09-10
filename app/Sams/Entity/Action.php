<?php

namespace Sams\Entity;

class Action extends \Eloquent {
	protected $fillable = ['title','description', 'state'];

	public function schedules() {
	  return $this->belongsToMany('Sams\Entity\Schedule')->withTimestamps();
	}
	
}