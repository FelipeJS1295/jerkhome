<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->date('fecha');
            $table->tinyInteger('desempeño')->unsigned();
            $table->tinyInteger('asistencia')->unsigned();
            $table->tinyInteger('habilidades_tecnicas')->unsigned();
            $table->tinyInteger('comunicacion')->unsigned();
            $table->text('comentarios')->nullable();
            $table->text('recomendaciones')->nullable();
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
        Schema::dropIfExists('evaluaciones');
    }
}
