<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'tags', 'image', 'customer_id', 'city', 'company'
    ];

    protected $casts = [
        'tags' => 'array'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
