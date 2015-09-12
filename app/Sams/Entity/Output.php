<?php

namespace Sams\Entity;

class Output extends \Eloquent {
	protected $fillable = ['date_start', 'date_end', 'type', 'state', 'info'];

	public function elder() {
		return $this->belongsTo('Sams\Entity\Elder');
	}

}