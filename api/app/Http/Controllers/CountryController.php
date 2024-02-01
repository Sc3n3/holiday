<?php

namespace App\Http\Controllers;

use App\Contracts\HolidayService;

class CountryController extends Controller
{
    /**
     * @param HolidayService $service
     * @return mixed
     */
    public function index(HolidayService $service)
    {
        return $service->getCountries();
    }
}
