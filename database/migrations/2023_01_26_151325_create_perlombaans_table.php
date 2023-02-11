<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perlombaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perlombaan');
            $table->text('deskripsi_perlombaan');
            $table->dateTime('tanggal_pendaftaran_dibuka');
            $table->dateTime('tanggal_pendaftaran_ditutup');
            $table->string('tempat_pelaksanaan');
            $table->string('status_perlombaan'); //single, team
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perlombaans');
    }
};
