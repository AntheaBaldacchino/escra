<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedIdea extends Model
{
    use HasFactory;
    protected $fillable = ['user_code', 'idea_text'];

    public function user() {

        return $this->belongsTo(User::class, 'user_id');
    }


}
