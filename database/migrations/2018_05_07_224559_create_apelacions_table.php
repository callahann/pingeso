<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApelacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apelacions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_declaracion');
            $table->string('comentario');
            $table->string('nombre_archivo')->nullable();
            $table->timestamps();

            $table->foreign('id_declaracion')
                ->references('id')
                ->on('declaracions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apelacions');
    }
}
