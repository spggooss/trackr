@extends('layouts.app')
@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">{{ __('Create New Package') }}</h1>
        <form action="{{ route('admin.packages.store') }}" method="POST" class="max-w-lg mx-auto">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700">{{ __('admin.packages.create.name') }}</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium text-gray-700">{{ __('admin.packages.create.email') }}</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="pickup_street_name" class="block font-medium text-gray-700">{{ __('admin.packages.create.pickup-street-name') }}</label>
                <input type="text" name="pickup_street_name" id="pickup_street_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="pickup_house_number" class="block font-medium text-gray-700">{{ __('admin.packages.create.pickup-house-number') }}</label>
                <input type="text" name="pickup_house_number" id="pickup_house_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="pickup_postal_code" class="block font-medium text-gray-700">{{ __('admin.packages.create.pickup-postal-code') }}</label>
                <input type="text" name="pickup_postal_code" id="pickup_postal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="pickup_city" class="block font-medium text-gray-700">{{ __('admin.packages.create.pickup-city') }}</label>
                <input type="text" name="pickup_city" id="pickup_city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="pickup_country" class="block font-medium text-gray-700">{{__('admin.packages.create.pickup-country') }}</label>
                <input type="text" name="pickup_country" id="pickup_country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="dropoff_street_name" class="block font-medium text-gray-700">{{ __('admin.packages.create.dropoff-street-name') }}</label>
                <input type="text" name="dropoff_street_name" id="dropoff_street_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="dropoff_house_number" class="block font-medium text-gray-700">{{ __('admin.packages.create.dropoff-house-number') }}</label>
                <input type="text" name="dropoff_house_number" id="dropoff_house_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="dropoff_postal_code" class="block font-medium text-gray-700">{{ __('admin.packages.create.dropoff-postal-code') }}</label>
                <input type="text" name="dropoff_postal_code" id="dropoff_postal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="dropoff_city" class="block font-medium text-gray-700">{{ __('admin.packages.create.dropoff-city') }}</label>
                <input type="text" name="dropoff_city" id="dropoff_city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="dropoff_country" class="block font-medium text-gray-700">{{ __('admin.packages.create.dropoff-country') }}</label>
                <input type="text" name="dropoff_country" id="dropoff_country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="post_company_id" class="block font-medium text-gray-700">{{ __('admin.packages.create.post-company') }}</label>
                <select name="post_company_id" id="post_company_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">{{__('admin.packages.create.post-company-placeholder')}}</option>
                    @foreach($postCompanies as $postCompany)
                        <option value="{{$postCompany->id}}">{{$postCompany->name}} - €{{number_format($postCompany->price, 2, ',')}}</option>
                    @endforeach
                </select>
            </div>

            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" type="submit">{{__('admin.packages.create.submit')}}</button>
        </form>
    </div>
@endsection
