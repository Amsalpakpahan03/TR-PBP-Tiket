<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKursiDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('kursi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kereta_id')->constrained('keretas')->onDelete('cascade');
            $table->string('kode'); // A1, A2, dst
            $table->string('status'); // 'kosong' atau 'terpakai'
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('kursi_details');
    }
}
