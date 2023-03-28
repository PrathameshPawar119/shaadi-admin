<?php

namespace App\Models;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'slug'
    ];

    
    public function customers(){
        return $this->belongsToMany(Customer::class, 'customers_skills', 'skills_id', 'customers_id');
    }
}
