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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 5000);  // Description with 5000 characters limit
            $table->string('tags')->nullable();   // Comma-separated tags
            $table->string('category');
            $table->string('image')->nullable();  // Path to the image
            $table->string('author');
            $table->date('post_date');            // New post_date field
            $table->timestamps();                 // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
