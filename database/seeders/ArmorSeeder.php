<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArmorSeeder extends Seeder
{
	public function run() {
		$this->insertIntoTable([
			'Armadura de Cuero',
			'Guerrero',
			'5',
			'7',
			'true'
		]);
		$this->insertIntoTable([
			'Capa Camuflada',
			'Pícaro',
			'2',
			'3',
			'true'
		]);
		$this->insertIntoTable([
			'Capa Armada',
			'Pícaro',
			'5',
			'6',
			'true'
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('armors')->insert([
			'name' => $data[0],
			'rpg_class' => $data[1],
			'added_health' => $data[2],
			'cost' => $data[3],
			'marketable' => $data[4]
		]);
	}
}
