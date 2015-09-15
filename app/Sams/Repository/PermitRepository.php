<?php

namespace Sams\Repository;

use Sams\Entity\Permit;

class PermitRepository extends BaseRepository {

	public function getModel() {
	 	return new Permit;
	}
	 
/*
	public function permitMonth($startDayMonth, $endDayMonth, $employeeId) {
		return Permit::where('date_star', '>=', $startDayMonth)
	 		           ->where('date_star', '<=', $endDayMonth)
	 		           ->where('employee_id', $employeeId);
	}

	public function getPermitRegular($employeeId, $date, $turn) {
		return Permit::where('employee_id', $employeeId)
	 		           ->where('state', 1)
	 		 					 ->where('date_star', $date)
	 		 					 ->where('turn', $turn)
	 		 					 ->orWhere(function ($query) use ($date, $employeeId) {
	 		 							$query->where('employee_id', $employeeId)
	 		 									  ->where('state', 1)
	 		 									  ->where('date_star', $date)
	 		 									  ->where('turn', 'complete');
	 		 						});
	}

	public function permitRegularIsBetween($employeeId, $date) {
		return Permit::where('employee_id', $employeeId)
	 			         ->where('date_star','<=', $date)
	 			         ->where('date_end', '>=', $date);
	}
	 			
	public function permitRegularInExtend($employeeId, $starDay, $endDay) {
		return Permit::where('employee_id', $employeeId)
	 			             ->where('date_star','>=', $starDay)
	 			             ->where('date_star','<=', $endDay);
	}
	 			
	public function permitExtendIsBetween($employeeId, $starDay, $endDay) {
		return Permit::where('employee_id', $employeeId)
	 		            ->where('date_star', '<=', $endDay)
			            ->where('date_end','>=', $endDay)
			            ->orWhere(function($query) use ($employeeId, $starDay, $endDay)  {
			               $query->where('employee_id', $employeeId)
			                		 ->where('date_star', '>=', $starDay)
			                		 ->where('date_end', '<=', $endDay);
			             })
			             ->orWhere(function($query) use ($employeeId, $starDay, $endDay) {
			              	$query->where('employee_id', $employeeId)
			                			->where('date_star', '<', $starDay)
			                			->where('date_end', '>=', $starDay)
			                		  ->where('date_end', '<=', $endDay);
			              });
	 		            
	}
	 	
	public function permitExtendActive($employeeId, $date)  {
		return Permit::where('employee_id', $employeeId)
	 		            ->where('date_star', '<=', $date)
	 		            ->where('date_end', '>=', $date);
	}*/
	 

}

