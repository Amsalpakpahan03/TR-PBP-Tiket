<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->string('asal')->nullable();
            $table->string('tujuan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->dropColumn(['asal', 'tujuan']);
        });
    }

};
