<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cococorn Admin</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <!-- Bootstrap 5 CSS (recommended CDN version) -->
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@if (session('success'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-all"
    >
        {{ session('success') }}
    </div>
@endif
<body class="bg-gray-100 font-sans antialiased">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="logo" class="h-9 w-9">
                    <p class="text-xl font-semibold mx-4 mt-4">Cococorn</p>
                </div>
                <div class="flex items-center">
                  

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 font-medium mx-2">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8 px-6">
        @yield('content')
    </main>
</body>
</html>
