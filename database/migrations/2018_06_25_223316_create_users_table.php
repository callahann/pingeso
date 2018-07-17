<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('nombres');
            $table->unsignedInteger('id_departamento');
            $table->unsignedInteger('id_jerarquia');
            $table->unsignedInteger('id_jornada');
            $table->unsignedInteger('id_rol');
            $table->unsignedInteger('id_comision')->nullable();
            $table->string('email')->unique();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_departamento')
                ->references('id')
                ->on('departamentos')
                ->onDelete('cascade');;
            $table->foreign('id_jerarquia')
                ->references('id')
                ->on('jerarquias')
                ->onDelete('cascade');;
            $table->foreign('id_jornada')
                ->references('id')
                ->on('jornadas')
                ->onDelete('cascade');;
            $table->foreign('id_rol')
                ->references('id')
                ->on('rols')
                ->onDelete('cascade');;
            $table->foreign('id_comision')
                ->references('id')
                ->on('comisions')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
