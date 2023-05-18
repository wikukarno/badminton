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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('email', 30)->unique();
            $table->string('role', 12)->default('1');
            $table->string('phone', 12)->nullable();
            $table->string('jenis_kelamin', 12)->nullable();
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('pekerjaan', 30)->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('kabupaten', 30)->nullable();
            $table->string('kecamatan', 30)->nullable();
            $table->string('desa', 30)->nullable();
            $table->longText('alamat')->nullable();
            $table->longText('photo')->nullable();
            $table->enum('status_account', ['pending', 'aktif', 'nonaktif', 'ditolak'])->default('pending');
            $table->longText('ktp')->nullable();
            $table->longText('kk')->nullable();
            $table->longText('alasan_penolakan')->nullable();
            // $table->timestamp('email_verified_at')->nullable(); // email_verified don't make the default value because it time
            $table->longText('password');
            // $table->rememberToken(); // remember token don't make the default value
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
        Schema::dropIfExists('users');
    }
};
