<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Fugo Creative</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="bg-slate-900 p-8 text-center">
            <h1 class="text-white text-3xl font-bold tracking-tight">Fugo<span class="text-emerald-400">Admin</span></h1>
            <p class="text-slate-400 mt-2">Sign in to manage your website</p>
        </div>
        <div class="p-8">
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                    <div class="relative">
                        <i class="ph ph-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="ph ph-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="password" name="password" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 mr-2">
                    <label for="remember" class="text-sm text-slate-600 ml-2">Remember me</label>
                </div>
                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                    Sign In <i class="ph-bold ph-arrow-right"></i>
                </button>
            </form>
            <div class="mt-8 text-center text-sm text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-slate-600 flex items-center justify-center gap-1"><i class="ph ph-arrow-left"></i> Back to Website</a>
            </div>
        </div>
    </div>
</body>
</html>
