<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Experience extends Model
{
    use HasFactory;

    protected $hidden = [
        'title', 'content', 'tags', 'image', 'content'
    ];

    protected $casts = [
        'tags' => 'array'
    ];


    public function customer()
    {
        return $this->HasOne(Customer::class, 'customers_experiences', 'experiences_id', 'customers_id');
    }
}
