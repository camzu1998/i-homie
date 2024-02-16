<!DOCTYPE html>
<html lang="pl" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/309a8b3aa5.js" crossorigin="anonymous"></script>
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
