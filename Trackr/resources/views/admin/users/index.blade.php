@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.webshop.users.create', ['webshop' => Auth::user()->webshop]) }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('admin.users.index.create-user') }}
                </a>
            </div>
            <form>
                <div class="mb-4">
                    <label for="name"
                           class="block text-gray-700 font-bold mb-2">{{__('admin.users.index.search')}}</label>
                    <input type="text" name="search" value="{{ $search ?? null }}"
                           placeholder="{{__('admin.users.index.search-placeholder')}}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="name">
                </div>

                <div class="mb-4">
                    <label for="sort"
                           class="block text-gray-700 font-bold mb-2">{{__('admin.users.index.sort')}}</label>
                    <select name="sort"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="sort">
                        <option value="">{{__('admin.users.index.sorting.default')}}</option>
                        <option
                            value="name:asc"{{ $sort === 'name:asc' ? ' selected' : '' }}>{{__('admin.users.index.sorting.name-asc')}}</option>
                        <option
                            value="name:desc"{{ $sort === 'name:desc' ? ' selected' : '' }}>{{__('admin.users.index.sorting.name-desc')}}</option>
                        <option
                            value="email:asc"{{ $sort === 'email:asc' ? ' selected' : '' }}>{{__('admin.users.index.sorting.email-asc')}}</option>
                        <option
                            value="email:desc"{{ $sort === 'email:desc' ? ' selected' : '' }}>{{__('admin.users.index.sorting.email-desc')}}</option>
                    </select>
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{__('admin.users.index.search-button')}}</button>
            </form>

            <table class="table-auto">
                <thead>
                <tr>
                    <th class="px-4 py-2">{{__('admin.users.index.table.name')}}</th>
                    <th class="px-4 py-2">{{__('admin.users.index.table.email')}}</th>
                    <th class="px-4 py-2">{{__('admin.users.index.table.role')}}</th>
                    <th class="px-4 py-2"></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($users as $user)
                    @if ($user->id !== Auth::user()->id)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2">{{ \App\Models\User\UserRole::create($user->role->name)->i18n() }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.webshop.users.edit', ['webshop' => $user->webshop, 'userId' => $user->id]) }}"
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('admin.users.index.edit') }}
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

            @if ($users->hasPages())
                <div class="flex justify-end">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </div>
@endsection
