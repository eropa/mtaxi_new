<?php

namespace App\Rules;

use App\Models\Drive;
use Illuminate\Contracts\Validation\Rule;

class UniqueNameAddress implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $matches = Drive::whereDriverfio(request()->name)
            ->whereGosnomer(request()->gosnomer)
            ->count();
        return $matches === 0;
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Существует такой водитель и ГОС номер автомобиля.';
    }
}
