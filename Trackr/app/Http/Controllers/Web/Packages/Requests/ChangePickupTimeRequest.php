<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePickupTimeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pickup_date_time' => 'required|pickup_time',
        ];
    }

    public function getPickupTime(): Carbon
    {
        return Carbon::create($this->get('pickup_date_time'));
    }

}
