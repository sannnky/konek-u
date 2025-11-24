<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
    'recruitment_id', 
    'user_id', 
    'message', 
    'status', 
    'is_pinned'];

    public function recruitment() {
        return $this->belongsTo(Recruitment::class);
    }

    public function user() {
        return $this->belongsTo(User::class); // User si pelamar
    }
}
