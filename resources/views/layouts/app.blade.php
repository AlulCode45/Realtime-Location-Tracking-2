<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <!-- Tracking Info & Buttons -->
                            <li class="nav-item d-flex align-items-center gap-3 me-3">
                                <div class="d-flex gap-2 align-items-center">
                                    <span class="badge bg-success">Lat: <span id="latitude">-</span></span>
                                    <span class="badge bg-success">Lng: <span id="longitude">-</span></span>
                                </div>
                                <button class="btn btn-outline-primary btn-sm" id="startTracking">
                                    <i class="bi bi-play-fill me-1"></i> Start
                                </button>
                                <button class="btn btn-outline-danger btn-sm" id="stopTracking">
                                    <i class="bi bi-stop-fill me-1"></i> Stop
                                </button>
                            </li>

                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bi bi-person-circle fs-5"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startButton = document.getElementById('startTracking');
            const stopButton = document.getElementById('stopTracking');
            const latitudeSpan = document.getElementById('latitude');
            const longitudeSpan = document.getElementById('longitude');

            let intervalId;

            function fetchLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const lat = position.coords.latitude.toFixed(6);
                        const lng = position.coords.longitude.toFixed(6);
                        latitudeSpan.textContent = lat;
                        longitudeSpan.textContent = lng;

                        console.log(`Latitude: ${lat}, Longitude: ${lng}`);
                    }, function (error) {
                        console.error('Error getting location:', error);
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            }

            startButton.addEventListener('click', function () {
                // Cegah duplikasi interval
                if (!intervalId) {
                    fetchLocation(); // Langsung ambil pertama kali
                    intervalId = setInterval(fetchLocation, 5000); // Setiap 10 detik
                    startButton.disabled = true;
                    stopButton.disabled = false;
                }
            });

            stopButton.addEventListener('click', function () {
                if (intervalId) {
                    clearInterval(intervalId);
                    intervalId = null;
                    latitudeSpan.textContent = '-';
                    longitudeSpan.textContent = '-';
                    startButton.disabled = false;
                    stopButton.disabled = true;
                }
            });

            // Set initial button state
            stopButton.disabled = true;
        });
    </script>

</body>

</html>