<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('pagos', function (Blueprint $table) {
        $table->id();
        $table->decimal('monto', 10, 2);
        $table->date('fecha');
        $table->string('metodo');

        // RELACIÓN
        $table->foreignId('cita_id')
              ->unique() 
              ->constrained('citas')
              ->onDelete('cascade');

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
