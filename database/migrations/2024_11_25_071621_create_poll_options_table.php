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
        Schema::create('poll_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('poll_id'); // ID of the voter
            $table->string('option_name');
            $table->string('image')->nullable();// Path or URL for the image
            $table->timestamps(); // Created_at and Updated_at timestamps
            
            // Foreign key constraint connecting to 'data' table's 'id' column
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_options');
    }
};
