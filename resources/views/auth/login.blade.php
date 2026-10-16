<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - FixIt</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-slate-200">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Login FixIt</h2>

        <!-- Tampilkan Error Jika Gagal Login -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Button -->
            <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-lg font-semibold hover:bg-blue-800 transition mb-4">
                Log in
            </button>

            <!-- Tautan Register / Pendaftaran Akun Baru -->
            @if (Route::has('register'))
                <div class="text-center text-sm text-slate-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                        Daftar di sini
                    </a>
                </div>
            @endif
        </form>
    </div>

</body>
</html>