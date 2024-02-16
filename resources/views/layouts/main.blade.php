<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <h1>@yield('header')</h1>
</header>
<div id="app"></div>
<main>
    @yield('content')
</main>

<footer>
    @yield('footer')
</footer>
</body>
</html>
