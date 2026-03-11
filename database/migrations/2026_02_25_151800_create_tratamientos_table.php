<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('tratamientos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion');
        $table->decimal('costo', 10, 2);

        // RELACIÓN
        $table->foreignId('historia_clinica_id')
              ->constrained('historia_clinicas')
              ->onDelete('cascade');

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
