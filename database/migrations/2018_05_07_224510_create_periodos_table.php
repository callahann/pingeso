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
            $table->dateTime('desde');
            $table->dateTime('hasta');
            $table->integer('estado');
            $table->integer('id_departamento');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_departamento')
                ->references('id')
                ->on('departamentos');
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