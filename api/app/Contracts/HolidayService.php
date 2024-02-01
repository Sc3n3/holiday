<?php

namespace App\Contracts;

interface HolidayService
{
    public function getCountries();
    public function getCountryHolidays($countryCode, $year);
}
