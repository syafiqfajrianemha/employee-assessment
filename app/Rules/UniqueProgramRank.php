<?php

namespace App\Rules;

use App\Models\Indicator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueProgramRank implements ValidationRule
{
    protected $programId;
    protected $currentIndicatorId;

    public function __construct($programId, $currentIndicatorId = null)
    {
        $this->programId = $programId;
        $this->currentIndicatorId = $currentIndicatorId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Indicator::where('program_id', $this->programId)
                           ->where('rank', $value)
                           ->where('id', '!=', $this->currentIndicatorId)
                           ->exists();

        if ($exists) {
            $fail("Rank {$value} sudah digunakan untuk program ini. Silakan pilih rank lain.");
        }
    }
}
