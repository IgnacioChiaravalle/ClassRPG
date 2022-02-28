<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RPGClassSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable([
			'Guerrero',
			'20',
			'10'
		]);
		$this->insertIntoTable([
			'Pícaro',
			'15',
			'15'
		]);
		$this->insertIntoTable([
			'Mago',
			'30',
			'5'
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('rpg_classes')->insert([
			'name' => $data[0],
			'base_health' => $data[1],
			'base_damage' => $data[2]
		]);
	}
}
