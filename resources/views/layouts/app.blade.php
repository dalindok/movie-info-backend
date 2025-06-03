<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cococorn Admin</title>
    <!-- Bootstrap & Tailwind CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    {{-- @if (session('success'))
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-all"
        >
            {{ session('success') }}
        </div>
    @endif

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    
                </div>
            </div>
        </div>
    </nav> --}}

    <!-- Layout: Sidebar + Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-52 bg-[#1D1616]
     text-white shadow-md h-screen hidden md:block ">
            <div class="p-4">
                <ul class="space-y-4">
                    <li>
                        <div class="flex items-center pb-6">
                            <img src="{{ asset('logo.png') }}" alt="logo" class="h-10 w-10">
                            <p class="text-2xl font-bold mx-2 mt-3">Cococorn</p>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="block  hover:text-blue-600 text-lg font-medium">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                     <li>
                        <a href="{{ route('movies.create') }}" class="block  hover:text-blue-600 text-lg font-medium">
                            <i class="bi bi-film me-2"></i> Add Movie
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('actor.create') }}" class="block  hover:text-blue-600 text-lg  font-medium">
                            <i class="bi bi-person-plus-fill me-2"></i> Create Actor
                        </a>
                    </li>
            
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class=" hover:text-red-600 font-medium  ">
                            Logout
                        </button>
                    </form>
                </ul>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
