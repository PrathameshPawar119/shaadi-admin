<?php

namespace App\Models\Customer;

use App\Models\City;
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
        'name', 'title', 'email', 'password', 'contact', 'email_verified_at', 'city'
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
        return $this->belongsToMany(Company::class, 'customers_companies', 'customers_id', 'companies_id');
    }

    public function cities(){
        return $this->hasOne(City::class, 'customers_cities', 'customers_id', 'cities_id');
    }

}
