<?php

namespace App\Services\OpenHolidays;

use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

use App\Contracts\HolidayService;

class Client implements HolidayService
{
    /**
     * @var PendingRequest
     */
    private $client;

    public function __construct()
    {
        $this->client = Http::baseUrl('https://openholidaysapi.org');
    }

    /**
     * @return array|mixed
     */
    public function getCountries()
    {
        return $this->client->get('/countries')->json();
    }

    /**
     * @param $countryCode
     * @param $year
     * @return void
     */
    public function getCountryHolidays($countryCode, $year)
    {
        $year = Carbon::createFromFormat('Y', $year);

        return $this->client->get('/PublicHolidays', [
            'languageIsoCode' => 'EN',
            'countryIsoCode' => $countryCode,
            'validFrom' => $year->startOfYear()->toDateString(),
            'validTo' => $year->endOfYear()->toDateString()
        ])->json();
    }
}
