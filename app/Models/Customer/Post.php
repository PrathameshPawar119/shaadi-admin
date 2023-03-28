<?php

namespace App\Models\Customer;

use App\Models\Company\Company;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'title', 'content', 'tags', 'image', 'creator', 'city'
    ];

    protected $casts = [
        'tags' => 'array',
        'comments' => 'array'
    ];

    public function companies()
    {
        return $this->belongsTo(Company::class, 'companies_posts', 'posts_id', 'companies_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customers_posts', 'posts_id', 'customers_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_posts', 'posts_id', 'tags_id');
    }

}
