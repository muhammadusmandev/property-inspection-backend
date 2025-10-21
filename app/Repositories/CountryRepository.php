<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepository as CountryRepositoryContract;
use App\Resources\CountryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class CountryRepository implements CountryRepositoryContract
{
    public function getAll(): AnonymousResourceCollection
    {
        $countries = Country::where('status',1)->get();
        return CountryResource::collection($countries);
    }


}
