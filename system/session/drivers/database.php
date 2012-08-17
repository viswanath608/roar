<?php namespace Session\Drivers;

use DB;
use Config;

class Database extends Driver {

	public function load($id) {
		$session = DB::table(Config::get('session.table'))->where('id', '=', $id)->fetch();

		if($session) {
			return array(
				'id' => $session->id,
				'date' => $session->date,
				'data' => unserialize($session->data)
			);
		}
	}

	public function save($session, $config, $exists) {
		if($exists) {
			DB::table($config['table'])->where('id', '=', $session['id'])->update(array(
				'date' => $session['date'],
				'data' => serialize($session['data'])
			));
		}
		else {
			DB::table($config['table'])->insert(array(
				'id' => $session['id'],
				'date' => $session['date'],
				'data' => serialize($session['data'])
			));
		}
	}

}