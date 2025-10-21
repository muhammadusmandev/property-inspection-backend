<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepository;
use App\Resources\CountryResource;
use App\Services\Contracts\CountryService as CountryServiceContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CountryService implements CountryServiceContract
{
    protected CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function listCountries(): AnonymousResourceCollection
    {
        return $this->countryRepository->getAll();
    }

}
