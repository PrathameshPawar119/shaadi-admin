<?php

namespace App\Models\Customer;

use App\Models\City;
use App\Models\Company\Company;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticate
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'title', 'email', 'password', 'contact', 'email_verified_at', 'city', 'slug'
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

    public function company()
    {
        return $this->hasOne(Company::class, 'creator');
    }

    public function companies(){
        return $this->belongsToMany(Company::class, 'customers_companies', 'customers_id', 'companies_id');
    }

    public function city(){
        return $this->hasOne(City::class, 'customers_cities', 'customers_id', 'cities_id');
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'customers_skills', 'customers_id', 'skills_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

}
