@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('super-admin.webshops.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('admin.webshops.index.create-webshop') }}
            </a>
        </div>
        <form>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">{{__('admin.webshops.index.search')}}</label>
                <input type="text" name="search" value="{{ $search ?? null }}" placeholder="{{__('admin.webshops.index.search-placeholder')}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name">
            </div>

            <div class="mb-4">
                <label for="sort" class="block text-gray-700 font-bold mb-2">{{__('admin.webshops.index.sort')}}</label>
                <select name="sort" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="sort">
                    <option value="">{{__('admin.packages.index.sorting.default')}}</option>
                    <option value="name:asc"{{ $sort === 'name:asc' ? ' selected' : '' }}>{{__('admin.webshops.index.sorting.name-asc')}}</option>
                    <option value="name:desc"{{ $sort === 'name:desc' ? ' selected' : '' }}>{{__('admin.webshops.index.sorting.name-desc')}}</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{__('admin.webshops.index.search-button')}}</button>
        </form>

        <table class="table-auto">
            <thead>
            <tr>
                <th class="px-4 py-2">{{__('admin.webshops.index.table.name')}}</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($webshops as $webshop)
                <tr>
                    <td class="border px-4 py-2">{{ $webshop->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if ($webshops->hasPages())
            <div class="flex justify-end">
                {{ $webshops->links('pagination::tailwind') }}
            </div>
        @endif

    </div>
</div>
@endsection
