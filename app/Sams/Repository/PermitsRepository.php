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

	 public function getPermissionExtend($idEmployee)

	 {
	 		return Permit::where('employee_id', $idEmployee)
	 		              ->where('state', 1)
	 		              ->where('type', 'extend');
	 		            
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

	 public function permissionBetween($idEmployee, $starDay, $endDay)

	 {
	 			return Permit::where('employee_id', $idEmployee)
	 			             ->where('date_star','>=', $starDay)
	 			             ->where('date_star', '<=', $endDay);
	 }

}
