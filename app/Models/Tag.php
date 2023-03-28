<?php

namespace App\Models;

use App\Models\Customer\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name', 'description'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'tags_posts', 'tags_id', 'posts_id');
    }

}
