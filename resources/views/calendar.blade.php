@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto mt-10 p-4">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">Mon Calendrier</h1>
        @livewire('calendar', [], key('calendar'))
    </div>
@endsection
