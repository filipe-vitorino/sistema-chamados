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
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');

            $table->text('descricao');

            $table->enum('prioridade', [
                'baixa',
                'media',
                'alta'
            ]);

            $table->enum('status', [
                'aberto',
                'em_andamento',
                'resolvido'
            ]);

            $table->foreignId('responsavel_id')
                ->constrained('responsaveis');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};
