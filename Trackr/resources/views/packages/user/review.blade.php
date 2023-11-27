@extends('layouts.app')
@section('content')
    <div class="container mx-auto mt-4">
        <h1 class="text-2xl font-bold mb-4">{{__('user.packages.review.title')}}</h1>
        <form action="{{ route('packages.review.store', ['packageId' => $packageId]) }}" method="POST"
              class="max-w-lg mx-auto">
            @csrf

            <div class="mb-4">
                <label for="rating" class="block font-medium text-gray-700">{{__('user.packages.review.rating')}}</label>
                <select name="rating" id="rating"
                        class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @for($i = 0; $i < 5; $i++)
                        <option value="{{$i + 1}}">{{$i + 1}}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label for="comment" class="block font-medium text-gray-700">{{__('user.packages.review.comment')}}</label>
                <textarea name="comment" id="comment"
                          class="shadow rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{__('user.packages.review.submit')}}</button>
        </form>
    </div>
@endsection
