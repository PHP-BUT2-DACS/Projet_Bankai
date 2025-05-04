<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bankai - Réseau Social</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gray-950 text-white">
<div class="min-h-screen flex flex-col">


    <!-- Main Content -->
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="lg:col-span-7">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl">Bienvenue sur <span class="text-blue-500">Bankai</span></h1>
                    <p class="mt-6 text-xl text-gray-400 max-w-3xl">
                        Rejoignez la communauté et partagez votre passion pour le sport avec des personnes du monde entier.
                    </p>
                    <div class="mt-10 sm:flex sm:space-x-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                            Créer un compte
                        </a>
                        <a href="{{ route('login') }}" class="mt-3 sm:mt-0 w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-gray-700 text-base font-medium rounded-md text-gray-300 bg-gray-900 hover:bg-gray-800 md:py-4 md:text-lg md:px-10">
                            Se connecter
                        </a>
                    </div>
                </div>
                <div class="mt-12 lg:mt-0 lg:col-span-5">
                    <div class="bg-gray-900 rounded-lg shadow-xl border border-gray-800 overflow-hidden">
                        <div class="px-6 py-8">
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-blue-500">Découvrez Bankai</h2>
                                <p class="mt-2 text-gray-400">Connectez-vous pour explorer le contenu</p>
                            </div>
                            <div class="mt-8 space-y-4">
                                <div class="flex items-center p-4 bg-gray-800 rounded-lg">
                                    <div class="flex-shrink-0 bg-blue-500 p-2 rounded-md">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-white">Communauté active</h3>
                                        <p class="text-sm text-gray-400">Échangez avec des milliers d'utilisateurs</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-4 bg-gray-800 rounded-lg">
                                    <div class="flex-shrink-0 bg-blue-500 p-2 rounded-md">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-white">Contenu personnalisé</h3>
                                        <p class="text-sm text-gray-400">Un flux adapté à vos sports préférés</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="text-gray-400 text-sm">
                    &copy; 2025 Bankai. Tous droits réservés.
                </div>
                <div class="space-x-4">
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="text-gray-400 hover:text-white">À propos</a>
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="text-gray-400 hover:text-white">Conditions</a>
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="text-gray-400 hover:text-white">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
