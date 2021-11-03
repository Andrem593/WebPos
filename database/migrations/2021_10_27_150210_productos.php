<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barras')->unique()->nullable();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->integer('cantidad');
            $table->string('unidad_medida')->nullable();
            $table->string('categoria')->nullable();
            $table->float('proveedor')->nullable();    
            $table->float('costo_proveedor')->nullable();
            $table->integer('stock')->nullable();
            $table->float('precio',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
