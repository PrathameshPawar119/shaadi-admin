<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'code'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];
}
