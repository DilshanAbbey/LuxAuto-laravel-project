<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuxParts</title>
  @vite('resources/css/app.css') <!-- Tailwind compiled with Vite -->
</head>
<body class="bg-gray-100 text-gray-900">

  <!-- Navbar -->
  <header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <a href="/" class="text-blue-600 font-bold text-2xl">LuxParts</a>
      <nav class="space-x-4">
        <a href="/shop" class="text-sm text-gray-700 hover:text-blue-600">Shop</a>
        <a href="/dashboard" class="text-sm text-gray-700 hover:text-blue-600">Dashboard</a>
        @auth
          <span class="text-sm">Welcome, {{ Auth::user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
          </form>
        @else
          <a href="/loginregister" class="text-sm text-gray-700 hover:text-blue-600">Login</a>
        @endauth
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-6">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-white text-center text-sm text-gray-500 py-4 border-t">
    &copy; {{ date('Y') }} LuxParts. All rights reserved.
  </footer>

</body>
</html>