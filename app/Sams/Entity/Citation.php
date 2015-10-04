<?php
namespace Sams\Entity;

class Citation extends \Eloquent {
	protected $fillable = ['elder_id', 'state', 'date_day', 'hour',
	                       'reason'];

	public function elder() {
		return $this->belongsTo('Sams\Entity\Elder');
	}

}