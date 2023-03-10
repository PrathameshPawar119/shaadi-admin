<?php

namespace App\Models\Customer;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticate
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'contact', 'email_verified_at'
    ];

    protected $hidden = [
        'password', 'email_verified_at'
    ];

    protected $casts =[
        'email_verified_at' => 'datetime'
    ];


    public function post(){
        return $this->hasMany(Post::class);
    }

    public function company(){
        return $this->hasMany(Company::class);
    }

}
