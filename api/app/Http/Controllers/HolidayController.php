<?php

namespace App\Http\Controllers;

use App\Contracts\HolidayService;
use App\Http\Requests\HolidayCreateRequest;
use App\Http\Requests\HolidaySearchRequest;
use App\Http\Requests\HolidayUpdateRequest;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Holiday::all();
    }

    /**
     * @param HolidayCreateRequest $request
     * @return \Illuminate\Support\Collection
     */
    public function store(HolidayCreateRequest $request)
    {
        $countryCode = $request->input('country');

        $saved = collect();

        foreach ($request->input('dates') as $holiday) {
            $model = new Holiday();

            $model
                ->setCountry($countryCode)
                ->setName($holiday['name'][0]['text'])
                ->setStartDate($holiday['startDate'])
                ->setEndDate($holiday['endDate']);

            $model->save();

            $saved->push($model);
        }

        return $saved;
    }

    /**
     * @param Holiday $holiday
     * @param HolidayUpdateRequest $request
     * @return Holiday
     */
    public function update(Holiday $holiday, HolidayUpdateRequest $request)
    {
        $holiday
            ->setName($request->input('name'))
            ->setStartDate($request->input('date'))
            ->setNote($request->input('note'));

        $holiday->save();

        return $holiday;
    }

    /**
     * @param Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return response()->noContent();
    }

    /**
     * @param HolidayService $service
     * @param HolidaySearchRequest $request
     * @return mixed
     */
    public function search(HolidayService $service, HolidaySearchRequest $request)
    {
        $results = $service->getCountryHolidays(
            $request->input('country'),
            $request->input('year')
        );

        return $results;
    }
}
