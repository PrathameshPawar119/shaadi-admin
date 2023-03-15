<?php

namespace App\Models;

use App\Models\Company\Company;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','url','status','state_code','country_code'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'customers_cities', 'cities_id', 'customers_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_cities', 'cities_id', 'companies_id');
    }
}
