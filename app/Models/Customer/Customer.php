<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;

class Customer extends Authenticate
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'contact', 'email_verified_at'
    ];

    protected $hidden = [
        'password', 'email_verified_at'
    ];

    protected $casts =[
        'email_verified_at' => 'datetime'
    ];
}
