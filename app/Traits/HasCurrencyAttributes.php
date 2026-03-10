<?php

namespace App\Traits;

use Exception;
use NumberFormatter;

trait HasCurrencyAttributes
{
    public function getCurrencyAttribute(string $attribute): string
    {
        if (! $this->hasAttribute($attribute)) {
            throw new Exception('No attribute by that name on this model');
        }

        $float = (float) (($this->getAttribute($attribute) ?: 0) / 100);

        return numfmt_format_currency(numfmt_create('en_GB', NumberFormatter::CURRENCY), $float, 'GBP');
    }
}
