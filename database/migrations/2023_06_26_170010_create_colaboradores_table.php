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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->unsignedBigInteger('idColaborador')->primary();
            $table->string('prenombres');
            $table->string('apellidos');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('pais');
            $table->string('codigoPostal');
            $table->date('fechaNacimiento');
            $table->string('descripcion');
            $table->timestamps();
            $table->foreign('idColaborador')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colaboradores');
    }
};
