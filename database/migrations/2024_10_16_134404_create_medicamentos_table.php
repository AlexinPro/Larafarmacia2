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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('descripcion', 1000);
            $table->date('caducidad');
            $table->decimal('precio', 8, 2);
            $table->foreignId('laboratorio_id')->constrained('laboratorios')->onUpdate('cascade')
            ->onDelete('restrict');
            $table->string('image', 80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
