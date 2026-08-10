<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boq_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('category')->nullable();
            $table->string('description');
            $table->string('unit')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->decimal('rate', 15, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boq_items');
    }
};
