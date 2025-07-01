<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('menu',30);
            $table->string('parts',20);
            $table->float('weight1')->nullable();
            $table->float('rep1')->nullable();
            $table->float('weight2')->nullable();
            $table->float('rep2')->nullable();
            $table->float('weight3')->nullable();
            $table->float('rep3')->nullable();
            $table->float('weight4')->nullable();
            $table->float('rep4')->nullable();
            $table->float('weight5')->nullable();
            $table->float('rep5')->nullable();
            $table->float('weight6')->nullable();
            $table->float('rep6')->nullable();
            $table->float('weight7')->nullable();
            $table->float('rep7')->nullable();
            $table->float('weight8')->nullable();
            $table->float('rep8')->nullable();
            $table->float('weight9')->nullable();
            $table->float('rep9')->nullable();
            $table->float('weight10')->nullable();
            $table->float('rep10')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('trainings');
    }
}
