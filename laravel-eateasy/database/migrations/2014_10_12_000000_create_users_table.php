<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Users', function (Blueprint $table) {
			$table->bigIncrements('id'); //primary key
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->boolean('esercente');
			$table->bigInteger('accessi')->default(0);
			$table->boolean('active');
            $table->boolean('verified')->default(false);
            $table->string('token')->nullable();
			$table->rememberToken();
			//STORED TIME INFORMATIN
			$table->timestamps(); //Adds created_at and updated_at columns.
			//KEY
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}
}
