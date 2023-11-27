@extends('layouts.app')

@push('scripts')
    @if(\Illuminate\Support\Facades\App::getLocale() === 'nl')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/lang/nl.js"></script>
    @else
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    @endif
@endpush

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <script defer>
            $(document).ready(function () {
                var calendar = $('#calendar').fullCalendar({
                    plugins: ['dayGrid'],
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: [
                        // Fetch and format pickup dates from your PHP code
                            @foreach ($packages as $package)
                        {
                            title: '{{ $package->id }} - {{ $package->name }}',
                            start: '{{ $package->pickupDateTime }}',
                        },
                        @endforeach
                    ]
                });

                calendar.render();
            });
        </script>
@endsection
