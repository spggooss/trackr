@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between">
                <h2 class="text-2xl font-bold">{{ __('admin.packages.index.title') }}</h2>
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <a href="{{ route('admin.packages.create') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('admin.packages.index.create-package') }}
                        </a>
                    </div>
                    <div class="ml-4">
                        <form action="{{ route('admin.packages.import') }}" method="post" enctype="multipart/form-data"
                              class="inline-block">
                            @csrf
                            <label for="csv-file">
                                {{ __('admin.packages.index.import-csv') }}
                            </label>
                            <input type="file" name="csv_file" id="csv_file">
                            <input type="submit"
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                        </form>
                    </div>
                </div>
            </div>
            <form>
                <div class="mb-4">
                    <label for="name"
                           class="block text-gray-700 font-bold mb-2">{{__('admin.packages.index.search')}}</label>
                    <input type="text" name="search" value="{{ $search ?? null }}"
                           placeholder="{{__('admin.packages.index.search-placeholder')}}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="name">
                </div>

                <div class="mb-4">
                    <label for="sort"
                           class="block text-gray-700 font-bold mb-2">{{__('admin.packages.index.sort')}}</label>
                    <select name="sort"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="sort">
                        <option value="">{{ __('admin.packages.index.sorting.choose') }}</option>
                        <option
                            value="name:asc"{{ $sort === 'pickup_date:asc' ? ' selected' : '' }}>{{__('admin.packages.index.sorting.pickup-date-asc')}}</option>
                        <option
                            value="name:desc"{{ $sort === 'pickup_date:desc' ? ' selected' : '' }}>{{__('admin.packages.index.sorting.pickup-date-desc')}}</option>
                        <option
                            value="email:asc"{{ $sort === 'email:asc' ? ' selected' : '' }}>{{__('admin.packages.index.sorting.email-asc')}}</option>
                        <option
                            value="email:desc"{{ $sort === 'email:desc' ? ' selected' : '' }}>{{__('admin.packages.index.sorting.email-desc')}}</option>
                    </select>
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{__('admin.packages.index.search-button')}}</button>
            </form>

            @if(count($packages) > 0)
                <form method="POST"
                      action="{{ route('label.generate.all', ['packageIds' => $packages->pluck('id')->all()]) }}">
                    @csrf
                    <button
                        class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        type="submit">{{__('admin.packages.index.generate-label-all')}}</button>
                </form>
            @endif

            @if ($packages->isEmpty())
                <p class="p-4">{{ __('admin.packages.index.no_records') }}</p>
            @else
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th class="px-4 py-2">{{ __('admin.packages.index.name') }}</th>
                        <th class="px-4 py-2">{{ __('admin.packages.index.email') }}</th>
                        <th class="px-4 py-2">{{ __('admin.packages.index.status') }}</th>
                        <th class="px-4 py-2">{{ __('admin.packages.index.pickup-address') }}</th>
                        <th class="px-4 py-2">{{ __('admin.packages.index.dropoff-address') }}</th>
                        <th class="px-4 py-2">{{ __('admin.packages.index.post-company') }}</th>
                        <th class="px-4 py-2">{{ __('admin.packages.index.trace-code') }}</th>
                        <th class="px-4 py-2">{{ __('admin.packages.index.pickup-date') }}</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($packages as $package)
                        <tr>
                            <td class="border px-4 py-2">{{ $package->name }}</td>
                            <td class="border px-4 py-2">{{ $package->email }}</td>
                            <td class="border px-4 py-2">{{ \App\Models\Package\PackageStatus::create($package->status)->i18n() }}</td>
                            <td class="border px-4 py-2">
                                {{ $package->pickup_address->street_name }} {{ $package->pickup_address->house_number }}
                                ,<br>
                                {{ $package->pickup_address->postal_code }} {{ $package->pickup_address->city }},<br>
                                {{ $package->pickup_address->country }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $package->dropoff_address->street_name }} {{ $package->dropoff_address->house_number }}
                                ,<br>
                                {{ $package->dropoff_address->postal_code }} {{ $package->dropoff_address->city }},<br>
                                {{ $package->dropoff_address->country }}
                            </td>

                            @if($package->post_company === null)
                                <td class="border px-4 py-2">
                                    <form method="POST"
                                          action="{{ route('admin.packages.change-post-company', ['packageId' => $package->id]) }}">
                                        @csrf
                                        <select name="post_company" id="post_company">
                                            @foreach($postCompanies as $postCompany)
                                                <option value="{{$postCompany->id}}">{{$postCompany->name}}
                                                    (€{{$postCompany->price}})
                                                </option>
                                            @endforeach
                                        </select>
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                            type="submit">{{__('admin.packages.index.change-pickup-time.submit')}}</button>
                                    </form>
                                </td>
                            @else
                                <td class="border px-4 py-2">{{ $package->post_company->name }}</td>
                            @endif
                            <td class="border px-4 py-2">{{ $package->trace_code }}</td>

                            @if($package->pickup_date === null)
                                <td class="border px-4 py-2">
                                    <form method="POST"
                                          action="{{route('admin.packages.change-pickup-time', ['packageId' => $package->id])}}">
                                        @csrf
                                        <input type="datetime-local" name="pickup_date_time" id="pickup_date_time"/>
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                            type="submit">{{__('admin.packages.index.change-pickup-time.submit')}}</button>
                                    </form>
                                </td>
                            @else
                                <td class="border px-4 py-2">{{ $package->pickup_date }} {{$package->pickup_time}}</td>
                            @endif
                            <td>
                                <form method="POST"
                                      action="{{route('label.generate', ['packageId' => $package->id])}}">
                                    @csrf
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        type="submit">{{__('admin.packages.index.generate-label')}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
