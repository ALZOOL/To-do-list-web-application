<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // public function teams()
    // {
    //     //return $this->belongsToMany(Team::class);
    // }

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'Authorization',
    ];
}
