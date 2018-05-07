<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeclaracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declaracions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_formulas');
            $table->unsignedInteger('id_usuario');
            $table->integer('periodo');
            $table->json('docencia_comp');
            $table->json('docencia_real');
            $table->json('investigacion_comp');
            $table->json('investigacion_real');
            $table->json('asistencia_comp');
            $table->json('asistencia_real');
            $table->json('perfeccionamiento_comp');
            $table->json('perfeccionamiento_real');
            $table->json('administracion_comp');
            $table->json('administracion_real');
            $table->json('extension_comp');
            $table->json('extension_real');
            $table->json('educacion_continua_comp');
            $table->json('educacion_continua_real');
            $table->integer('estado');
            $table->timestamps();

            $table->foreign('id_formula')
                ->references('id')
                ->on('formulas');

            $table->foreign('id_usuario')
                ->references('id')
                ->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declaracions');
    }
}
