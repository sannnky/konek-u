<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'avatar',
    'bio',
    'skills',
    'major'
    ];

    // Relasi: User punya banyak postingan
    public function recruitments() {
        return $this->hasMany(Recruitment::class);
    }

    // Relasi: User punya banyak lamaran (ke tim orang lain)
    public function applications() {
        return $this->hasMany(Application::class);
    }
}
