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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();

            // person
            $table->string('salutation')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('company')->nullable();

            // business
            $table->string('segment');
            $table->string('location');

            // needs
            $table->string('service');
            $table->string('system_type')->nullable();
            $table->string('monthly_bill')->nullable();
            $table->string('timeline')->nullable();
            $table->string('preferred_contact')->nullable();
            $table->text('details')->nullable();

            // workflow / meta
            $table->string('status')->default('new');
            $table->string('source')->default('website');
            $table->ipAddress('ip')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('segment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
