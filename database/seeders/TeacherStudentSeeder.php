<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherStudentSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable(['Admin Teacher', 'Student 1']);
		$this->insertIntoTable(['Admin Teacher', 'Student 2']);
		$this->insertIntoTable(['Admin Teacher', 'Student 3']);
	}

	private function insertIntoTable(array $data) {
		DB::table('teacher_students')->insert([
			'teacher_name' => $data[0],
			'student_name' => $data[1]
		]);
	}
}
