@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-4">
        <div class="bg-white shadow-lg rounded-lg">
            <div class="px-6 py-4 bg-gray-100 border-b">
                <h2 class="text-lg font-semibold">{{ __('packages.show.title') }}</h2>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4">{{ __('packages.show.id') }}: {{ $package->id }}</h3>
                <p class="text-gray-700 mb-2">{{ __('packages.show.user_id') }}: {{ $package->user_id }}</p>
                <p class="text-gray-700 mb-2">{{ __('packages.show.status') }}: {{ $package->status }}</p>
                <p class="text-gray-700 mb-2">{{ __('packages.show.pickup_date') }}: {{ $package->pickup_date }}</p>
                <p class="text-gray-700 mb-2">{{ __('packages.show.pickup_time') }}: {{ $package->pickup_time }}</p>
                <p class="text-gray-700 mb-2">{{ __('packages.show.pickup_address') }}
                    : {{ $package->pickup_address?->full_address }}</p>
                <p class="text-gray-700 mb-2">{{ __('packages.show.dropoff_address') }}
                    : {{ $package->dropoff_address?->full_address }}</p>
                @isset($package->user)
                    <p class="text-gray-700 mb-2">{{ __('packages.show.user') }}: {{ $package->user->name }}</p>
                @endisset
                <p class="text-gray-700 mb-2">{{ __('packages.show.trace_code') }}: {{ $package->trace_code }}</p>
                @auth
                    <form action="{{ route('packages.add-to-account', ['packageId' => $package->id, 'email' => Auth::user()->email]) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            {{ __('packages.show.add_to_account') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">{{ __('packages.show.login_to_add') }}</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
