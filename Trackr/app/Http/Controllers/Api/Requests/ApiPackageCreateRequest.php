<?php

namespace App\Http\Controllers\Api\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiPackageCreateRequest extends FormRequest
{
    public function rules(): array{
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'dropoff_street_name' => 'required|string',
            'dropoff_house_number' => 'required|string',
            'dropoff_postal_code' => 'required|string',
            'dropoff_city' => 'required|string',
            'dropoff_country' => 'required|string',
            'pickup_street_name' => 'required|string',
            'pickup_house_number' => 'required|string',
            'pickup_postal_code' => 'required|string',
            'pickup_city' => 'required|string',
            'pickup_country' => 'required|string',
        ];

    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = [
            'message' => 'The given data was invalid.',
            'errors' => $errors,
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }

    public function getStatus(){
        return $this->get('status');
    }
    public function getDropoffStreetName()
    {
        return $this->get('dropoff_street_name');
    }

    public function getDropoffHouseNumber()
    {
        return $this->get('dropoff_house_number');
    }

    public function getName(){
        return $this->get('name');
    }

    public function getEmail(){
        return $this->get('email');
    }

    public function getDropoffPostalCode()
    {
        return $this->get('dropoff_postal_code');
    }

    public function getDropoffCity()
    {
        return $this->get('dropoff_city');
    }

    public function getDropoffCountry()
    {
        return $this->get('dropoff_country');
    }

    public function getPickupStreetName()
    {
        return $this->get('pickup_street_name');
    }

    public function getPickupHouseNumber()
    {
        return $this->get('pickup_house_number');
    }

    public function getPickupPostalCode()
    {
        return $this->get('pickup_postal_code');
    }

    public function getPickupCity()
    {
        return $this->get('pickup_city');
    }

    public function getPickupCountry()
    {
        return $this->get('pickup_country');
    }


}
