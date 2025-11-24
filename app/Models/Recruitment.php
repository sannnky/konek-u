<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'title', 
        'category', 
        'description', 
        'requirements', 
        'location', 
        'deadline', 
        'status', 
        'proposal_file',
        'is_pinned' 
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}