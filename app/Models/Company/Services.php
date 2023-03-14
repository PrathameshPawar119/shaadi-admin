<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name', 'description', 'slug', 'status'
    ];
}
