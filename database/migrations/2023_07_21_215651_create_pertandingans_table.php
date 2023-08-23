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
        Schema::create('pertandingans', function (Blueprint $table) {
            $table->id();
            $table->string('perlombaans_id', 12);
            $table->enum('status', ['menunggu', 'berlangsung', 'selesai'])->default('menunggu');
            $table->string('pesertas_id_1', 12);
            $table->string('pesertas_id_2', 12);
            $table->dateTime('tanggal_jadwal');
            $table->string('skor_peserta_1_set_1', 5)->nullable();
            $table->string('skor_peserta_2_set_1', 5)->nullable();
            $table->string('skor_peserta_1_set_2', 5)->nullable();
            $table->string('skor_peserta_2_set_2', 5)->nullable();
            $table->string('skor_peserta_1_set_3', 5)->nullable();
            $table->string('skor_peserta_2_set_3', 5)->nullable();
            $table->string('durasi', 5)->nullable();
            $table->string('pemenang_id', 12)->nullable();
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
        Schema::dropIfExists('pertandingans');
    }
};
