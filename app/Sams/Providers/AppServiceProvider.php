<?php

namespace Sams\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use Sams\Entity\User;
use Sams\Entity\Elder;
use Sams\Entity\Instance;
use Sams\Entity\Record;
use Sams\Entity\Citation;
use Sams\Entity\Occurrence;
use Sams\Entity\Output;
use Sams\Entity\Employee;
use Sams\Entity\Attendance;
use Sams\Entity\Permit;
use Sams\Entity\Action;
use Sams\Entity\Occasion;
use Sams\Entity\Product;
use Sams\Entity\Audit;


class AppServiceProvider extends ServiceProvider {

  public function boot() {

    User::created(function ($event) {
      $notification = ' ha registrado al usuario id:'.$event->id;
      
      $this->createAudit($notification);
      
    });

    User::updated(function ($event) {
      $notification = ' ha actualizado al usuario id:'.$event->id;

      $this->createAudit($notification);

    });

    User::deleted(function ($event) {
      $notification = ' ha eliminado al usuario id:'.$event->id;

      $this->createAudit($notification);
      
    });

    Employee::created(function ($event) {
      $notification = ' ha registrado al empleado id:'.$event->id;

      $this->createAudit($notification);
    });

    Employee::updated(function ($event) {
      $notification = ' ha actualizado al empleado id:'.$event->id;

      $this->createAudit($notification);
    });

    Employee::deleted(function ($event) {
      $notification = ' ha eliminado al empleado id:'.$event->id;

      $this->createAudit($notification);
    });

    Elder::created(function ($event) {
      $notification = ' ha registrado al adulto mayor id:'.$event->id;

      $this->createAudit($notification);
    });

    Elder::updated(function ($event) {
      $notification = ' ha actualizado al adulto mayor id:'.$event->id;

      $this->createAudit($notification);
    });

    Elder::deleted(function ($event) {
      $notification = ' ha eliminado al adulto mayor id:'.$event->id;

      $this->createAudit($notification);
    });

    Instance::created(function ($event) {
      $notification = ' ha registrado notificacion de entrada id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Instance::updated(function ($event) {
      $notification = ' ha actualizado notificacion de entrada id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Instance::deleted(function ($event) {
      $notification =  ' ha eliminado notificacion de entrada id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Citation::created(function ($event) {
      $notification = ' ha registrado cita id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Citation::updated(function ($event) {
      $notification =  ' ha actualizado cita id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Citation::deleted(function ($event) {
      $notification = ' ha eliminado cita id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Record::created(function ($event) {
      $notification = ' ha registrado historia clinica:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Record::updated(function ($event) {
      $notification = ' ha actualizado historia clinica:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Record::deleted(function ($event) {
      $notification = ' ha eliminado historia clinica:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Occurrence::created(function ($event) {
      $notification = ' ha registrado incidencia:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);
    });

    Occurrence::updated(function ($event) {
      $notification = ' ha actualizado incidencia:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);

    });

    Occurrence::deleted(function ($event) {
      $notification = ' ha eliminado incidencia:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);

    });

    Output::created(function ($event) {
      $notification = ' ha registrado salida:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);

    });

    Output::updated(function ($event) {
      $notification =  ' ha actualizado salida:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);

    });

    Output::deleted(function ($event) {
      $notification = ' ha eliminado salida:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      $this->createAudit($notification);

    });

    Attendance::updated(function ($event) {
      $notification = ' ha actualizado asistencia:'.$event->id.' del empleado id:'.$event->employee_id;

      $this->createAudit($notification);

    });

    Permit::created(function ($event) {
      $notification = ' ha registrado permiso id:'.$event->id.' del empleado id:'.$event->employee_id;

      $this->createAudit($notification);

    });

    Permit::updated(function ($event) {
      $notification = ' ha actualizado permiso id:'.$event->id.' del empleado id:'.$event->employee_id;

      $this->createAudit($notification);

    });

    Permit::deleted(function ($event) {
      $notification = ' ha eliminado permiso id:'.$event->id.'del empleado id:'.$event->employee_id;

      $this->createAudit($notification);
    });

    Action::created(function ($event) {
      $notification = ' ha registrado actividad id:'.$event->id;

      $this->createAudit($notification);

    });

    Action::updated(function ($event) {
      $notification = ' ha actualizado actividad id:'.$event->id;

      $this->createAudit($notification);

    });

    Action::deleted(function ($event) {
      $notification = ' ha eliminado actividad id:'.$event->id;

      $this->createAudit($notification);

    });

    Occasion::created(function ($event) {
      $notification = ' ha registrado el evento id:'.$event->id;

      $this->createAudit($notification);

    });

    Occasion::updated(function ($event) {
      $notification = ' ha actualizado el evento id:'.$event->id;

      $this->createAudit($notification);

    });

    Occasion::deleted(function ($event) {
      $notification = ' ha eliminado el evento id:'.$event->id;

      $this->createAudit($notification);

    });

    Product::created(function ($event) {
      $notification =  ' ha registrado el producto id:'.$event->id;

      $this->createAudit($notification);

    });

    Product::updated(function ($event) {
      $notification = ' ha actualizado producto id:'.$event->id;

      $this->createAudit($notification);

    });

    Product::deleted(function ($event) {
      $notification = ' ha eliminado producto id:'.$event->id;

      $this->createAudit($notification);

    });


  }

  public function createAudit($notification) {
    if (Auth::check()) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email.$notification;

      Audit::create(['message' => $message]);
    }
  }


  public function register() {
    //
  }
}