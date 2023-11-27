<?php

namespace App\Http\Controllers\Web\GeneralRequests;


use App\Auth\Gates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

abstract class Request extends FormRequest
{

    abstract public function rules();

    public function authorize()
    {

        return Auth::check();
    }
}
