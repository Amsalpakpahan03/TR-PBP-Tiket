<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeretasTable extends Migration
{
    public function up()
    {
        Schema::create('keretas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kelas');
            $table->string('jurusan');
            $table->date('tanggal_berangkat');
            $table->time('jam_berangkat');
            $table->decimal('harga', 10, 2);
            $table->json('nomor_kursi'); // contoh: ["A1", "A2", ...]
            $table->integer('ketersediaan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keretas');
    }
}
