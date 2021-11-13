<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Caja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->float('valor_inicio',8,2);
            $table->float('faturacion_dia',8,2)->nullable();
            $table->float('total_caja',8,2)->nullable();
            $table->string('vendedor')->nullable();            
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
        Schema::dropIfExists('cajas');
    }
}
