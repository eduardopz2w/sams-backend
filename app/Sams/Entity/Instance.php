<?php

namespace Sams\Entity;

class Instance extends \Eloquent {
	protected $fillable = ['elder_id', 'referred', 'address', 'visit', 'description'];

	public function elder()

	{
		 $this->belongsTo('Sams\Entity\Elder');
	}

}