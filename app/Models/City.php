<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','url','status','state_code','country_code'
    ];


//     #[SearchUsingPrefix(['name', 'url'])]
// //    #[SearchUsingFullText(['url'])]
//     public function toSearchableArray()
//     {
//         return [
//             'name' => $this->name,
//             'url' => $this->url,
//         ];
//     }
}
