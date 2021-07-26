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

		$this->call(RPGClassSeeder::Class);
		$this->call(WeaponSeeder::Class);
		$this->call(ItemSeeder::Class);
		$this->call(ArmorSeeder::Class);

		$this->call(UserSeeder::Class);
		$this->call(TeacherSeeder::Class);
		$this->call(StudentSeeder::Class);
	}

	private function truncateTables(array $tables) {
		foreach ($tables as $table)
			DB::table($table)->truncate();
	}

}