@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-4">{{ __('user.packages.index.title') }}</h2>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex justify-between items-start p-4">
                @if ($packages->isEmpty())
                    <p class="p-4">{{ __('user.packages.index.no_records') }}</p>
                    <a href="{{ route('user.package.search') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('user.packages.index.search_package') }}
                    </a>
                @else
                    <a href="{{ route('user.package.search') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('user.packages.index.search_package') }}
                    </a>
            </div>
            <table class="w-full">
                <thead>
                <tr>
                    <th>{{ __('user.packages.index.id') }}</th>
                    <th>{{ __('user.packages.index.name') }}</th>
                    <th>{{ __('user.packages.index.email') }}</th>
                    <th>{{ __('user.packages.index.status') }}</th>
                    <th>{{ __('user.packages.index.pickup_date') }}</th>
                    <th>{{ __('user.packages.index.pickup_time') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($packages as $package)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $package->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $package->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $package->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $package->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $package->pickup_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $package->pickup_time }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($package->status === 'delivered')
                                @if($package->review_id === null)
                                <a href="{{route('packages.review', ['packageId' => $package->id])}}"
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{__('user.packages.index.review')}}</a>
                                @else
                                    <p>{{ __('user.packages.index.reviewed') }}</p>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection
