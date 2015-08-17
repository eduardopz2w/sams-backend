<?php

namespace Sams\Entity;

class Relative extends \Eloquent {
	protected $fillable = ['identity_card', 'full_name', 'affective_relations','phone', 
	                       'elder_id'];

	public function elder()

	{
			return $this->belongsTo('Sams\Entity\Elder');
	}

	public function outputs()

	{
			return $this->hasMany('Sams\Entit\Output');
	}

}