<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable(['Admin Teacher', 'Real Admin Teacher', 'admin@admin.com', 'admin', 'teacher']);
		$this->insertIntoTable(['Student 1', 'Real Student 1', 'student1@student.com', 'student', 'student']);
		$this->insertIntoTable(['Student 2', 'Real Student 2', 'student2@student.com', 'student', 'student']);
		$this->insertIntoTable(['Student 3', 'Real Student 3', 'student3@student.com', 'student', 'student']);
	}

	private function insertIntoTable(array $data) {
		DB::table('users')->insert([
			'name' => $data[0],
			'real_name' => $data[1],
			'email' => $data[2],
			'password' => Hash::make($data[3]),
			'type' => $data[4]
		]);
	}
}
