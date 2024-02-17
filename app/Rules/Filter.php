<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{
    protected $forbidden;

    /**
     * @param $forbidden
     */
    public function __construct($forbidden)
    {
        $this->forbidden = $forbidden;
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(in_array($value, $this->forbidden)) {
            $fail('this value is not allowed');
        }
    }


}
