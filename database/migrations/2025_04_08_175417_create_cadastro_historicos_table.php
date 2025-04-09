<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::create('cadastro_historicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id');
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->string('cep');
            $table->string('estado_civil');
            $table->string('time');
            $table->string('profissao');
            $table->decimal('salario', 10, 2);
            $table->timestamps();
            
            $table->foreign('original_id')->references('id')->on('cadastros');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('cadastro_historicos');
    }
};
