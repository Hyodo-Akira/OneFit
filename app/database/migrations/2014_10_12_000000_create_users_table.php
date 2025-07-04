<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',20);
            $table->string('email',30)->unique();
            $table->string('image',100)->nullable();
            $table->string('password',100);
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('sex',10)->nullable();
            $table->float('pal')->nullable();
            $table->float('target')->nullable();
            $table->float('fitcoin')->default(0);
            $table->string('role')->default(1);
            $table->boolean('del_flg')->default(false);
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
        Schema::dropIfExists('users');
    }
}
