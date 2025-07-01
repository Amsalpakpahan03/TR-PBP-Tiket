<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('tikets', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('kereta_id');
        $table->string('asal');
        $table->string('tujuan');
        $table->date('tanggal');
        $table->decimal('harga', 10, 2);
        $table->string('kursi');
        $table->enum('status', ['pending', 'sukses'])->default('pending');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};
