<?php

namespace App\Services;

use App\Models\PhoneNumber;

class PhoneNumberService
{
    public function __construct(private PhoneNumber $phoneNumber = new PhoneNumber())
    {
    }

    /**
     * @return \App\Models\PhoneNumber
     */
    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $number
     * @return $this
     */
    public function assignData(
        string $number
    ):static
    {
        $this->phoneNumber->number = $number;
        $this->phoneNumber->save();
        return $this;
    }
}
