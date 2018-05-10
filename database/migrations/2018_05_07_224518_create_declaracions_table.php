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
            $table->unsignedInteger('id_formula')->nullable();
            $table->unsignedInteger('id_usuario')->nullable();
            $table->integer('periodo');
            $table->json('docencia_comp')->nullable();
            $table->json('docencia_real')->nullable();
            $table->json('investigacion_comp')->nullable();
            $table->json('investigacion_real')->nullable();
            $table->json('asistencia_comp')->nullable();
            $table->json('asistencia_real')->nullable();
            $table->json('perfeccionamiento_comp')->nullable();
            $table->json('perfeccionamiento_real')->nullable();
            $table->json('administracion_comp')->nullable();
            $table->json('administracion_real')->nullable();
            $table->json('extension_comp')->nullable();
            $table->json('extension_real')->nullable();
            $table->json('educacion_continua_comp')->nullable();
            $table->json('educacion_continua_real')->nullable();
            $table->integer('estado')->default(0);
            $table->timestamps();
            /*
            $table->foreign('id_formula')
                ->references('id')
                ->on('formulas');

            $table->foreign('id_usuario')
                ->references('id')
                ->on('users');
            */

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
