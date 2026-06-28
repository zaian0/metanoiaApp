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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('excerpt', 500)->nullable();
            $table->longText('body'); // Markdown source

            $table->string('cover_image')->nullable();
            $table->string('author')->nullable();

            // SEO overrides (fall back to title/excerpt when empty)
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();

            $table->string('status')->default('draft'); // draft | published
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
