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
            $table->string('nama_perlombaan', 30);
            $table->longText('deskripsi_perlombaan');
            $table->dateTime('tanggal_pendaftaran_dibuka');
            $table->dateTime('tanggal_pendaftaran_ditutup');
            $table->dateTime('tanggal_pelaksanaan');
            $table->string('tempat_pelaksanaan', 30);
            $table->string('kategori_perlombaan', 30); //single, team
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
