<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchResolution implements ValidationRule
{
    public function __construct(public string $resolution) {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ranges = [
            '1080P' => [1920, 1080, 2560, 1440],
            '2K' => [2560, 1440, 3840, 2160],
            '4K' => [3840, 2160, null, null],
        ];
        [$width, $height] = getimagesize($value->getRealPath());
        [$minW, $minH, $maxW, $maxH] = $ranges[$this->resolution];
        if ($width < $minW || $height < $minH || ($maxW && ($width > $maxW || $height > $maxH))) {
            $fail('Uploaded file resolution does not match selected resolution');
        }
    }
}
