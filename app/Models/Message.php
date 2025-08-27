<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Tentukan field yang boleh diisi secara massal (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'content',
    ];
}
