<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crimes', function (Blueprint $table) {
        $table->id();
        $table->string('cidade');
        $table->string('bairro');
        $table->string('tipo_crime');
        $table->date('data_ocorrencia')->nullable();
        $table->integer('vitima_idade')->nullable();
        $table->string('vitima_genero')->nullable();
        $table->text('descricao')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crimes');
    }
};
