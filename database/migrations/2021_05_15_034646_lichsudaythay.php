<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lichsudaythay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lichsudaythay', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('magv');
            $table->integer('magvdoi');
            $table->integer('tuan');
            $table->date('thang');
            $table->integer('malop');
            $table->integer('buoi');
            $table->integer('thu');
            $table->integer('tiet');
            $table->integer('mamon');
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
        //
    }
}
