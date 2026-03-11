<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('citas', function (Blueprint $table) {
        $table->id();
        $table->date('fecha');
        $table->string('hora');
        $table->string('estado');

        // RELACIONES
        $table->foreignId('paciente_id')
              ->constrained('pacientes')
              ->onDelete('cascade');

        $table->foreignId('odontologo_id')
              ->constrained('odontologos')
              ->onDelete('cascade');


        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
