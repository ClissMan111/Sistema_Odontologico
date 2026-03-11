<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('historia_clinicas', function (Blueprint $table) {
        $table->id();
        $table->date('fecha');
        $table->string('diagnostico');
        $table->text('observaciones');

        // RELACIÓN
        $table->foreignId('paciente_id')
              ->constrained('pacientes')
              ->onDelete('cascade');

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('historia_clinicas');
    }
};
