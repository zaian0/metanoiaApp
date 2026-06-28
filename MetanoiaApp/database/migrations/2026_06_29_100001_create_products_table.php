<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();

            // Translatable content (EN + AR on one record).
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('summary_en', 500)->nullable();
            $table->string('summary_ar', 500)->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();

            $table->json('tags')->nullable();   // ["on-grid","1500V", ...]
            $table->json('specs')->nullable();  // [{label_en,label_ar,value}, ...]

            $table->string('status')->default('draft'); // draft | published
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
