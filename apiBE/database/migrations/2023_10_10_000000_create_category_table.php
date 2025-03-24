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
        Schema::dropIfExists('category'); // Add this line to drop the table if it exists

        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });

        // Ensure the product table exists before adding the foreign key constraint
        if (Schema::hasTable('product')) {
            Schema::table('product', function (Blueprint $table) {
                $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product')) {
            Schema::table('product', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        }

        Schema::dropIfExists('category');
    }
};
