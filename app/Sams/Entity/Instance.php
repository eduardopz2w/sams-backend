<?php

namespace Sams\Entity;

class Instance extends \Eloquent {
	protected $fillable = ['elder_id', 'referred', 'address', 'visit_date', 
												 'admission_date', 'description'];

	public function elder()

	{
		 return $this->belongsTo('Sams\Entity\Elder');
	}


}