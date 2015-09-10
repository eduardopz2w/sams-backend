<?php

namespace Sams\Entity;

class Record extends \Eloquent {
	
	protected $fillable = ['pathology_psychiatric', 'pathology_chronic', 'allergies','feeding_assisted',
	                       'index_katz', 'index_lawtonbrody', 'disability_physical', 'disability_psychic', 'mime',
	                       'feeding_asistidad', 'size_diaper', 'baston', 'muleta', 'wheelchair', 'walker','image_url',
	                       'disability_moto','disability_visual', 'disability_hearing','self_validating', 'elder_id', 'state'];
  
  public function elder()

  {
  		return $this->belongsTo('Sams\Entity\Elder');
  }

}