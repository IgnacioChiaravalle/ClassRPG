<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherStudentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teacher_students', function (Blueprint $table) {
			$table->id();
			$table->string('teacher_name');
			$table->foreign('teacher_name')->references('name')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
			$table->string('student_name');
			$table->foreign('student_name')->references('name')->on('students')->onDelete('cascade')->onUpdate('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('teacher_students');
	}
}
