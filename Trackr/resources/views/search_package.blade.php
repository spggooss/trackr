@extends('layouts.app')

@section('content')
    <div
        class="relative flex justify-center items-center min-h-screen bg-dots-darker bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

        <div class="container mx-auto">
            <div class="flex justify-center">
                <div class="w-8/12">
                    <div class="bg-white p-6 rounded-lg">
                        <div class="text-xl font-bold mb-6">{{ __('home.track-and-trace') }}</div>

                        <form method="GET" action="{{ route('packages.find-package') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="trace_code"
                                       class="block text-sm font-medium text-gray-700">{{ __('home.track-and-trace-code') }}</label>
                                <input id="trace_code" type="text" name="trace_code" value="{{ old('trace_code') }}"
                                       required autofocus
                                       class="form-input mt-1 block w-full rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('trace_code') border-red-500 @enderror">

                                @error('trace_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="postal_code"
                                       class="block text-sm font-medium text-gray-700">{{ __('home.postal-code') }}</label>
                                <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}"
                                       required
                                       class="form-input mt-1 block w-full rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('postal_code') border-red-500 @enderror">

                                @error('postal_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('home.track') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
