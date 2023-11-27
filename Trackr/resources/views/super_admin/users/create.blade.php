@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium leading-6 text-gray-900">Create User</h2>
                    <form method="POST" action="{{ route('super-admin.users.store') }}">
                        @csrf
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full" required autofocus />
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="email" class="block font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="form-input rounded-md shadow-sm mt-1 block w-full" required />
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="password" class="block font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="form-input rounded-md shadow-sm mt-1 block w-full" required />
                            @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="webshop_id" class="block font-medium text-gray-700">Webshop</label>
                            <select name="webshop_id" id="webshop_id" class="form-select mt-1 block w-full">
                                @foreach ($webshops as $webshop)
                                    <option value="{{$webshop->id }}">{{$webshop->name }}</option>
                                @endforeach
                            </select>
                            @error('webshop')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="role" class="block font-medium text-gray-700">Role</label>
                            <select name="role" id="role" class="form-select mt-1 block w-full">
                                @foreach (\App\Models\User\UserRole::getAll() as $role)
                                    <option value="{{ \App\Models\User\UserRole::create($role)->getValue() }}">{{ \App\Models\User\UserRole::create($role)->i18n() }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-8">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
