<?php

namespace App\Rules\ShiftEmployee;

use App\Models\ShiftEmployee;
use Illuminate\Contracts\Validation\Rule;

class UniquePerShift implements Rule
{

    private $shift_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($shift_id)
    {
        $this->shift_id = $shift_id;
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
        return ShiftEmployee::where(['shift_id' => $this->shift_id, 'employee_id' => $value])->get()->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Данный сотрудник уже присутствует в смене';
    }
}
