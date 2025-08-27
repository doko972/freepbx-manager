<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MacAddress implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $value);
    }

    public function message()
    {
        return 'L\'adresse MAC doit être au format XX:XX:XX:XX:XX:XX ou XX-XX-XX-XX-XX-XX.';
    }
}