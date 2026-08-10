<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['material', 'labour', 'equipment', 'other'])->default('material');
            $table->string('description');
            $table->decimal('quantity', 15, 2)->default(0);
            $table->string('unit')->nullable();
            $table->decimal('rate', 15, 2)->default(0);
            $table->date('date')->nullable();
            $table->string('vendor')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
