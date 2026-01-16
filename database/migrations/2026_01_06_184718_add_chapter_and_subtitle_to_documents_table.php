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
        // Add chapter and subtitle columns to documents table
        Schema::table('documents', function (Blueprint $table) {
            $table->string('chapter')->nullable()->after('id');
            $table->string('subtitle')->nullable()->after('chapter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove chapter and subtitle columns from documents table
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['chapter', 'subtitle']);
        });
    }
};
