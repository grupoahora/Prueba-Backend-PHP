<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiales', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');

            $table->unsignedInteger('id_bodega_origen')->nullable();
            $table->unsignedInteger('id_bodega_destino')->nullable();
            $table->unsignedInteger('id_inventario')->nullable();


            $table->foreign('id_bodega_origen')->references('id')->on('bodegas')->nullOnDelete();
            $table->foreign('id_bodega_destino')->references('id')->on('bodegas')->nullOnDelete();
            $table->foreign('id_inventario')->references('id')->on('inventarios')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historiales');
    }
}
