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
        // Create users table
        // Set storage engine to InnoDB for foreign key support
        Schema::create('users', function (Blueprint $table) {
                       $table->engine = 'InnoDB';
            $table->id();
            $table->char('user_code', 4)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DROP users table
        Schema::dropIfExists('users');
    }
};
