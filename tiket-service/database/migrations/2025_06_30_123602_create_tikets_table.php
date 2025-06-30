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
    Schema::create('tiket', function (Blueprint $table) {
        $table->id();
        $table->integer('user_id');
        $table->integer('kereta_id');
        $table->string('asal');
        $table->string('tujuan');
        $table->date('tanggal');
        $table->integer('harga');
        $table->string('status')->default('pending');
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
        Schema::dropIfExists('tikets');
    }
};
