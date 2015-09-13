<?php

namespace Sams\Repository;

use Sams\Entity\Elder;

class ElderRepository extends BaseRepository{
	
	public function getModel() {
		return new Elder;
	}

	public function elderWithRecord($id) {
	  return Elder::where('elders.id', $id)
	           		 ->leftJoin('records', 'elders.id', '=', 'records.elder_id')
             		 ->orderBy('records.created_at', 'DESC')
	           		 ->select('*', 'elders.id')
	           		 ->first();
	}

	public function findEldersByName($name) {
		return Elder::where('full_name', 'LIKE', '%'.$name.'%')
	               ->take(5)
	               ->get()
	               ->toArray();
	}

	public function findElderByIdentify($identityCard) {
		return Elder::where('identity_card', $identityCard);
	}
	
	public function elders($state) {
		$join = Elder::leftJoin('records', 'elders.id', '=', 'records.elder_id')
			    			  ->select('elders.id', 
			    				  	    'elders.full_name', 
			    				  	    'elders.identity_card',
			    							  'records.image_url'
			    							  );
			    				  
    if ($state == 'active') {
		  $elders = $join->where('activiti', 1);
    } else {
    	$elders = $join->where('activiti', 0);
    }

		return $elders;
	}
	
}