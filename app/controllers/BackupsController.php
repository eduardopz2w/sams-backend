<?php

class BackupsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /backups
	 *
	 * @return Response
	 */
	public function index() {
		$backups = Backup::orderBy('created_at', 'desc')->get();

    foreach ($backups as $backup) {
      $backup->setPrettyName();
    }

    return Response::json($backups);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /backups/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /backups
	 *
	 * @return Response
	 */
	public function store()
	{
		$dir = substr(__DIR__, 0, 20).'backups/';
    $newBackup = new Backup;
    $newBackup->save();
    $command = 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump.exe -uroot sams > '.$dir.$newBackup->getDateTimeString().'.sql';

    exec($command);

    return Response::json(['message' => 'Backup success!']);
	}

	/**
	 * Display the specified resource.
	 * GET /backups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /backups/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /backups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /backups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}