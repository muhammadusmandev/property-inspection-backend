<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\Controller;
use App\Services\Contracts\CountryService as CountryServiceContract;
use App\Traits\{ Loggable, ApiJsonResponse };
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected CountryServiceContract $countryService;

    public function __construct(CountryServiceContract $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        try {
            $data = $this->countryService->listCountries();
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e, 'Country list failed');
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()]);
        }
    }
}
