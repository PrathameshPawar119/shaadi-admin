<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Models\City;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LocationController extends Controller
{
    use HttpResponses;

    public function getAllCities():JsonResponse|AnonymousResourceCollection
    {
        try {
            $cities = City::where('status',true)->where('country_code','IN')->orderBy('name')->get();
            throw_if($cities->count() == 0,'no city found!');
            return CityResource::collection($cities);

        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }
}
