<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('description');  // Changed to longText for larger content
            $table->string('author');
            $table->enum('type', ['video', 'image'])->default('image');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->date('date');
            $table->boolean('is_active')->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
