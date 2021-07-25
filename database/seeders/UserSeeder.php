<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	public function run() {
		$this->insertIntoTable(['Admin Teacher', 'admin@admin.com', 'admin', 'teacher']);
		$this->insertIntoTable(['Student 1', 'student@student.com', 'student', 'student']);
	}

	private function insertIntoTable(array $data) {
		DB::table('users')->insert([
			'name' => $data[0],
			'email' => $data[1],
			'password' => Hash::make($data[2]),
			'type' => $data[3]
		]);
	}
}
