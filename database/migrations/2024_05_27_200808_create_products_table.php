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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category')->default('uncategorized');
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->enum('status', ['draft', 'published', 'sold', 'inactive', 'archived'])->default('published');
            $table->boolean('is_approved')->default(false);
            $table->enum('condition', ['new', 'like new', 'gently used', 'used', 'vintage', 'fair', 'poor'])->default('new');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
