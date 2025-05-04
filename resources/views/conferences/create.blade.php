@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Créer une nouvelle conférence</h1>

        <!-- Afficher les messages de succès ou d'erreur -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire pour créer une conférence -->
        <form action="{{ route('conferences.store') }}" method="POST">
            @csrf

            <!-- Champ Titre -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('title') border-red-500 @enderror">
                @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Date de début -->
            <div class="mb-4">
                <label for="start" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de début</label>
                <input type="datetime-local" name="start" id="start" value="{{ old('start') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('start') border-red-500 @enderror">
                @error('start')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Date de fin -->
            <div class="mb-4">
                <label for="end" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de fin</label>
                <input type="datetime-local" name="end" id="end" value="{{ old('end') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('end') border-red-500 @enderror">
                @error('end')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton Soumettre -->
            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Créer la conférence
                </button>
            </div>
        </form>
    </div>
@endsection
