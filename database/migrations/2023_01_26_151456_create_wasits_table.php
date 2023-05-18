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
        Schema::create('wasits', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 30);
            $table->string('email', 30);
            $table->string('phone', 12);
            $table->string('status', 30);
            $table->longText('photo');
            $table->longText('alamat');
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
        Schema::dropIfExists('wasits');
    }
};
