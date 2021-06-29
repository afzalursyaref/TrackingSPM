<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkpkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skpk', function (Blueprint $table) {
            $table->id();
            $table->string('nm_skpk');
            $table->integer('kd_urusan');
            $table->integer('kd_bidang');
            $table->integer('kd_unit');
            $table->integer('kd_sub');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skpk');
    }
}
