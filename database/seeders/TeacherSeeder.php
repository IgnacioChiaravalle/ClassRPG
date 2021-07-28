<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable(['Admin Teacher']);
	}

	private function insertIntoTable(array $data) {
		DB::table('teachers')->insert([
			'name' => $data[0]
		]);
	}
}
