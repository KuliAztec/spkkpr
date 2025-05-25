<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="antialiased bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                Welcome to Laravel!
            </h1>
            <p class="text-lg text-gray-600">
                Build something amazing with Laravel and Tailwind CSS
            </p>
        </div>
    </body>
</html>