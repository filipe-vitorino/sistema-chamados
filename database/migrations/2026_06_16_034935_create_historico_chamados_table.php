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
        Schema::create('historico_chamados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamado_id')->constrained()->onDelete('cascade');
            $table->string('campo_alterado');
            $table->string('valor_antigo')->nullable();
            $table->string('valor_novo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_chamados');
    }
};
