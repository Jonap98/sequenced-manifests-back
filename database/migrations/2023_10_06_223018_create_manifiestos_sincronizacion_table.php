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
        Schema::create('MANIFIESTOS_sincronizacion', function (Blueprint $table) {
            $table->id();
            $table->string('brazo');
            $table->string('tramo');
            $table->string('ubicacion');
            $table->string('scanner');
            $table->string('diferencia');
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
        Schema::dropIfExists('manifiestos_sincronizacion');
    }
};
