<?php

namespace Sams\Repository;

use Sams\Entity\Elder;

class ElderRepository extends BaseRepository{
	
	public function getModel()

	{
			return new Elder;
	}

	public function findElderByIdentify($identify)

	{
	  return Elder::where('identity_card', $identify);
	}


	public function findEldersByName($name)

	{
	  return Elder::where('full_name', 'LIKE', '%'.$name.'%')
	              ->take(5)
	              ->get()
	              ->toArray();
	}

	public function elders($state)

	{
	  $join = Elder::leftJoin('records', 'elders.id', '=', 'records.elder_id')
			    			 ->select('elders.id', 
			    				  	    'elders.full_name', 
			    				  	    'elders.identity_card',
			    							  'records.image_url'
			    							  );
			    				  
    if ($state == 'active')

		{
		  $query = $join->where('activiti', 1);
		}

		else

		{
		  $query = $join->where('activiti', 0);
		}

		return $query;
	}

	public function elderWithRecord($id)

	{
	  return  Elder::where('elders.id', $id)
	           ->leftJoin('records', 'elders.id', '=', 'records.elder_id')
	           ->select('*', 'elders.id')
	           ->first();

	}
}