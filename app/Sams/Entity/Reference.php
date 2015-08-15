<?php

namespace Sams\Entity;

class Reference extends \Eloquent {
	protected $fillable = ['elder_id', 'citation_id', 'treatment', 'description', 'expert',
	                       'issued'];

	public function citation()

	{
			return $this->belongsTo('Sams\Entity\Citation');
	}

	public function elder()

	{
		 return $this->belongsTo('Sams\Entity\Elder');
	}
}