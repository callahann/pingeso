<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->dateTime('desde');
            $table->dateTime('hasta');
            $table->integer('etapa')->default(1);
            $table->integer('id_departamento');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_departamento')
                ->references('id')
                ->on('departamentos')
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
        Schema::dropIfExists('periodos');
    }
}
