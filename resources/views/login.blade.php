<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <form method="POST" action="/login" class="bg-white p-8 rounded shadow-md w-96">
        @csrf
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" required class="w-full p-2 border border-gray-300 rounded mt-1" value="{{ old('email') }}">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
    </form>

</body>
</html>
