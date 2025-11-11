<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegas', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre', 30);
            $table->unsignedInteger('id_responsable')->nullable();

            $table->foreign('id_responsable')->references('id')->on('users')->nullOnDelete();

            $table->tinyInteger('estado')
                ->default(1)
                ->comment('1=activo, 0=inactivo');
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
        Schema::dropIfExists('bodegas');
    }
}
