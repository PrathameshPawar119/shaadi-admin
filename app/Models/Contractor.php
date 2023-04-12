<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;

class Contractor extends Authenticable
{
    use HasFactory;
    protected $fillable = [
        "name", "email", "contact", "password", "email_verified_at"
    ];

    protected $hidden = [
        "password", "email_verified_at"
    ];

    protected $casts = [
        "email_verified_at" => "datetime"
    ];
}
