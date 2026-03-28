<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Bidify - Online Auction Platform') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="icon" href="favicon1.ico" type="image/x-icon">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/frontend-style.css') }}">
    </head>
    <body>
        <!-- Header -->
        <header class="header">
          <div class="container header-content">
            <a href="{{ route('welcome') }}" class="logo"><img src="{{ asset('assets/images/mlogo.jpg') }}" alt="Bidify Logo"></a>
            <nav class="nav">
              <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">Home</a>
              <a href="{{ route('auctions.index') }}" class="{{ request()->routeIs('auctions.*') ? 'active' : '' }}">Auctions</a>
              <a href="{{ route('frontend.categories.index') }}" class="{{ request()->routeIs('frontend.categories.*') ? 'active' : '' }}">Categories</a>
              <a href="{{ route('how-it-works') }}" class="{{ request()->routeIs('how-it-works') ? 'active' : '' }}">How It Works</a>
            </nav>
            <div class="header-actions">
              @auth
                <div class="dropdown me-3">
                  <button class="btn btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ auth()->user()->name }}
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                    </li>
                  </ul>
                </div>
              @else
                <a href="{{ route('login') }}" class="btn btn-outline me-2">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
              @endauth
            </div>
          </div>
        </header>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Axios for AJAX -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        
        <!-- Laravel Echo for Real-time -->
        @vite(['resources/js/app.js'])
    </body>
</html>
