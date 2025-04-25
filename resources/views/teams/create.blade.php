@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-700 dark:text-gray-300">Créer une nouvelle équipe</h1>

        <form action="{{ route('teams.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 dark:text-gray-300">Nom de l'équipe</label>
                <input type="text" name="name" id="name" required
                       class="w-full border rounded px-3 py-2 mt-1 @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sport_id" class="block font-medium text-gray-700 dark:text-gray-300">Sport</label>
                <select name="sport_id" id="sport_id" required
                        class="w-full border rounded px-3 py-2 mt-1 @error('sport_id') border-red-500 @enderror">
                    <option value="">-- Choisir un sport --</option>
                    @foreach ($sports as $sport)
                        <option value="{{ $sport->id }}">{{ $sport->name }}</option>
                    @endforeach
                </select>
                @error('sport_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Créer l’équipe
            </button>
        </form>
    </div>
@endsection
