<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'title', 'content', 'tags', 'image', 'creator'
    ];

    protected $casts = [
        'tags' => 'array',
        'comments' => 'array'
    ];
}
