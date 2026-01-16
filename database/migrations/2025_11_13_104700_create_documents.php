<?php

namespace App\Models;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    
return new class extends Migration
{
    public function up():void 
{
    // Create documents table
     Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longText('content')->nullable();
            $table->string('google_doc_id')->nullable();
            $table->timestamps();
        });
}

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
    
};
