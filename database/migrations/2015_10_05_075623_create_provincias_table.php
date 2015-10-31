<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provincias', function(Blueprint $table) {
            
            $table->increments('id_provincia')->unique();
            $table->string('nombre_provincia');
            $table->text('descripcion_provincia');
            $table->boolean('estado_provincia');
            $table->integer('id_pais');
            $table->integer('id_region');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('provincias');
    }
}