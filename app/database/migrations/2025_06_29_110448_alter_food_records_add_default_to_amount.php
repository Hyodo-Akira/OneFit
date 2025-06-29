<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFoodRecordsAddDefaultToAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_records', function (Blueprint $table) {
            $table->dropColumn('amount');
        });

        Schema::table('food_records', function (Blueprint $table) {
            // デフォルト値を設定して再追加
            $table->float('amount')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amount', function (Blueprint $table) {
            //
        });
    }
}
