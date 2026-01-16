<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
   use HasFactory;

    protected $fillable = ['user_id', 'chapter', 'subtitle', 'content', 'google_doc_id'];


    public function user()
    {
        // Document belongs to a User
        return $this->belongsTo(User::class, 'user_id');
    }
}
