<?php

namespace Sams\Repository;

use Sams\Entity\Permit;

class PermitsRepository extends BaseRepository {

	 public function getModel()

	 {
	 		 return new Permit;
	 }

	 public function permissionsMonth($startDayMonth, $endDayMonth, $idEmployee)

	 {
	 	  return Permit::where('date_star', '>=', $startDayMonth)
	 		               ->where('date_star', '<=', $endDayMonth)
	 		               ->where('employee_id', $idEmployee);
	 }

	 public function getPermissionRegular($date, $idEmployee, $turn)

	 {
	 		 return Permit::where('employee_id', $idEmployee)
	 		              ->where('state', 1)
	 		 							->where('date_star', $date)
	 		 							->where('turn', $turn)
	 		 							->orWhere(function ($q) use ($date, $idEmployee) {
	 		 									$q->where('employee_id', $idEmployee)
	 		 									  ->where('state', 1)
	 		 									  ->where('date_star', $date)
	 		 									  ->where('turn', 'complete');
	 		 							});
	 }

	 public function permissionsBetweenRegular($idEmployee, $date)

	 {
	 			return Permit::where('employee_id', $idEmployee)
	 			             ->where('date_star','<=', $date)
	 			             ->where('date_end', '>=', $date);
	 }

	 public function permissionBetweenExtend($idEmployee, $starDay, $endDay)

	 {
	 			return Permit::where('employee_id', $idEmployee)
	 			             ->where('date_star','>=', $starDay)
	 			             ->where('date_star','<=', $endDay);
	 }

	 public function getPermissionExtend($idEmployee, $starDay, $endDay)

	 {
	 		return Permit::where('employee_id', $idEmployee)
	 		               ->where('date_star', '<=', $endDay)
			               ->where('date_end','>=', $endDay)
			               ->orWhere(function($q) use ($idEmployee, $starDay, $endDay)  {
			                		$q->where('employee_id', $idEmployee)
			                		  ->where('date_star', '>=', $starDay)
			                		  ->where('date_end', '<=', $endDay);
			                })
			                ->orWhere(function($q) use ($idEmployee, $starDay, $endDay) {
			                		$q->where('employee_id', $idEmployee)
			                		  ->where('date_star', '<', $starDay)
			                		  ->where('date_end', '>=', $starDay)
			                		  ->where('date_end', '<=', $endDay);
			                });
	 		            
	 }

	 public function getPermitActivity($idEmployee, $date)

	 {
	 		return Permit::where('employee_id', $idEmployee)
	 		             ->where('date_star', '<=', $date)
	 		             ->where('date_end', '>=', $date);
	 }

}

