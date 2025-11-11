<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('id_bodega')->nullable();
            $table->unsignedInteger('id_producto')->nullable();
            
            $table->foreign('id_bodega')->references('id')->on('bodegas')->nullOnDelete();
            $table->foreign('id_producto')->references('id')->on('productos')->nullOnDelete();

            $table->integer('cantidad');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('inventarios');
    }
}
