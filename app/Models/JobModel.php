<?php

namespace App\Models;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'min_experience', 'location', 'skills', 'image', 'starting_date', 'tags', 'company_id'
    ];  

    protected $casts = [
        'starting_date' => 'datetime',
        'skills' => 'array',
        'tags' => 'array'
    ];



    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
