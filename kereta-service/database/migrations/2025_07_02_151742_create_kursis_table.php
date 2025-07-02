<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kursis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kereta_id');
            $table->string('kode'); // Contoh: A1, A2
            $table->boolean('tersedia')->default(true);
            $table->timestamps();

            $table->foreign('kereta_id')->references('id')->on('keretas')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kursis');
    }
};
