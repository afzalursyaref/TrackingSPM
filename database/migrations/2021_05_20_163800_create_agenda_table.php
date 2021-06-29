<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor');
            $table->string('kode');
            $table->foreignId('skpk_id')->nullable();
            $table->dateTime('tgl_agenda');
            $table->string('dari');
            $table->string('no_hp');
            $table->foreignId('user_id')->nullable();
            $table->string('user_input');
            $table->foreignId('disposisi_user_id')->nullable();
            $table->string('no_spm');
            $table->date('tgl_spm');
            $table->string('jenis_spm');
            $table->string('uraian');
            $table->string('nm_penerima');
            $table->string('bank_penerima');
            $table->string('rek_penerima');
            $table->string('npwp');
            $table->decimal('jml_kotor', 14, 2);
            $table->decimal('potongan', 14, 2);
            $table->decimal('jml_bersih', 14, 2);
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
        Schema::dropIfExists('agenda');
    }
}
