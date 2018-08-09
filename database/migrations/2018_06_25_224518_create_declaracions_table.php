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
            $table->unsignedInteger('id_periodo')->nullable();
            $table->unsignedInteger('id_apelacion')->nullable();
            $table->json('item_docencia')->nullable();
            $table->json('item_investigacion')->nullable();
            $table->json('item_asistencia')->nullable();
            $table->json('item_perfeccionamiento')->nullable();
            $table->json('item_administracion')->nullable();
            $table->json('item_extension')->nullable();
            $table->json('item_educacion_continua')->nullable();
            $table->json('resumenes')->nullable();
            $table->json('totales')->nullable();
            $table->decimal('calificacion_final',8,3)->default(0.0);
            $table->integer('estado')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_formula')
                ->references('id')
                ->on('formulas')
                ->onDelete('cascade');

            $table->foreign('id_usuario')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('id_periodo')
                ->references('id')
                ->on('periodos')
                ->onDelete('cascade');
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
