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

    /*User::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado al usuario id:'.$event->id;
      
      Audit::create(['message' => $message]);
      
    });

    User::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado al usuario id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    User::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado al usuario id:'.$event->id;

      Audit::create(['message' => $message]);
      
    });

    Employee::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado al empleado id:'.$event->id;

      Audit::create(['message' => $message]);
    });

    Employee::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario'.$user->email. 'ha actualizado al empleado id:'.$event->id;

      Audit::create(['message' => $message]);
    });

    Employee::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado al empleado id:'.$event->id;

      Audit::create(['message' => $message]);
    });

    Elder::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado al adulto mayor id:'.$event->id;

      Audit::create(['message' => $message]);
    });

    Elder::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado al adulto mayor id:'.$event->id;

      Audit::create(['message' => $message]);
    });

    Elder::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado al adulto mayor id:'.$event->id;

      Audit::create(['message' => $message]);
    });

    Instance::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado notificacion de entrada id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Instance::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado notificacion de entrada id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Instance::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado notificacion de entrada id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Citation::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado cita id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Citation::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado cita id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Citation::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado cita id:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Record::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado historia clinica:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Record::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado historia clinica:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Record::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado historia clinica:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Occurrence::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado incidencia:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);
    });

    Occurrence::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado incidencia:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);

    });

    Occurrence::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado incidencia:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);

    });

    Output::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado salida:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);

    });

    Output::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado salida:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);

    });

    Output::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado salida:'.$event->id.' del adulto mayor id:'.$event->elder_id;

      Audit::create(['message' => $message]);

    });

    Attendance::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado asistencia:'.$event->id.' del empleado id:'.$event->employee_id;

      Audit::create(['message' => $message]);

    });

    Permit::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado permiso id:'.$event->id.' del empleado id:'.$event->employee_id;

      Audit::create(['message' => $message]);

    });

    Permit::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado permiso id:'.$event->id.' del empleado id:'.$event->employee_id;

      Audit::create(['message' => $message]);

    });

    Permit::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado permiso id:'.$event->id.'del empleado id:'.$event->employee_id;

      Audit::create(['message' => $message]);
    });

    Action::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado actividad id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Action::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado actividad id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Action::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado actividad id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Occasion::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado el evento id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Occasion::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado el evento id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Occasion::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado el evento id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Product::created(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha registrado el producto id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Product::updated(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha actualizado producto id:'.$event->id;

      Audit::create(['message' => $message]);

    });

    Product::deleted(function ($event) {
      $user = Auth::user();
      $message = 'El usuario '.$user->email. ' ha eliminado producto id:'.$event->id;

      Audit::create(['message' => $message]);

    });*/


  }


  public function register() {
    //
  }
}