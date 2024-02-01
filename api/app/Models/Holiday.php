<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $date
     * @return $this
     */
    public function setStartDate($date)
    {
        $this->start_date = $date;
        return $this;
    }

    /**
     * @param $date
     * @return $this
     */
    public function setEndDate($date)
    {
        $this->end_date = $date;
        return $this;
    }

    /**
     * @param $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @param $note
     * @return $this
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }
}
