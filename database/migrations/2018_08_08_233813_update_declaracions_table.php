<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDeclaracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declaracions', function (Blueprint $table) {
            $table->foreign('id_apelacion_superior')
                ->references('id')
                ->on('apelacions')
                ->onDelete('cascade');
            $table->foreign('id_apelacion_facultad')
                ->references('id')
                ->on('apelacions')
                ->onDelete('cascade');
            $table->foreign('id_apelacion_departamental')
                ->references('id')
                ->on('apelacions')
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
        //
    }
}
