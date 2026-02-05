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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The uploader/artist
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('technique_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('institution_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('year')->nullable();
            $table->string('dimensions')->nullable(); // e.g., "100x200 cm"
            $table->text('description')->nullable();
            
            // Media
            $table->string('image_path'); // Main artwork image
            $table->json('gallery_images')->nullable(); // Additional angles/details
            
            // Status
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};
