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
        Schema::create('voting_list', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('voter_id'); // Voter ID
            $table->unsignedBigInteger('poll_id'); // Poll ID
            $table->unsignedBigInteger('poll_option_id'); // Poll Option ID
            $table->integer('vote_count')->default(0); // Number of votes
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('voter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
            $table->foreign('poll_option_id')->references('id')->on('poll_options')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_list');
    }
};
