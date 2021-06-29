<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengelola_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('user_input')->nullable();
            $table->boolean('terima')->default(false);
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
        Schema::dropIfExists('bud');
    }
}
