<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no"/>
        <title>Incidents</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('vendor/fejlvarp/app.css') }}">
    </head>
    <body>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </body>
</html>
