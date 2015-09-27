<?php

use Sams\Entity\Audit;

class AuditController extends BaseController {
  public function getAudit() {
    $audits = Audit::all();

    if ($audits->count() == 0) {
      $response = [
        'status' => 'error',
        'message' => 'No hay registro de actividades'
      ];
    } else {
      $response = [
        'status' => 'success',
        'data' => $audits
      ];
    }

    return Response::json($response);
  }
}