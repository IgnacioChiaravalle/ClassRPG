<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function (Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
			$table->foreign('name')->references('name')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->string('rpg_class');
			$table->foreign('rpg_class')->references('name')->on('rpg_classes')->onDelete('cascade')->onUpdate('cascade');
			$table->string('weapon')->nullable();
			$table->foreign('weapon')->references('name')->on('weapons')->onDelete('cascade')->onUpdate('cascade');
			$table->string('item')->nullable();
			$table->foreign('item')->references('name')->on('items')->onDelete('cascade')->onUpdate('cascade');
			$table->string('armor')->nullable();
			$table->foreign('armor')->references('name')->on('armors')->onDelete('cascade')->onUpdate('cascade');
			$table->unsignedInteger('coins');
			$table->unsignedInteger('health');
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
		Schema::dropIfExists('students');
	}
}
