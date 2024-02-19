<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'completed',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;
}
