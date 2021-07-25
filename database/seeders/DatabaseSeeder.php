<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

	public function run() {
		$this->truncateTables([
			'users',
			'password_resets',
		]);

		$this->call(UserSeeder::Class);
	}

	private function truncateTables(array $tables) {
		foreach ($tables as $table)
			DB::table($table)->truncate();
	}

}