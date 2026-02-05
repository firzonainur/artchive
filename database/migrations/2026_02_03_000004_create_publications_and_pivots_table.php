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
        // Publications / Research Papers
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Author
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('abstract')->nullable();
            $table->string('file_path')->nullable(); // PDF download
            $table->string('external_link')->nullable(); // DOI or external URL
            $table->date('published_date')->nullable();
            $table->timestamps();
        });

        // Pivot: Artworks <-> Publications (Many-to-Many)
        // An artwork can be cited in many papers, a paper can discuss many artworks.
        Schema::create('artwork_publication', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
            $table->foreignId('publication_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot: Favorites (User <-> Artwork)
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'artwork_id']);
        });
        
        // Comments for Artworks
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('artwork_publication');
        Schema::dropIfExists('publications');
    }
};
