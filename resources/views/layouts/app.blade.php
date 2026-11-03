<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RAM Parfum - Exclusive Perfumery')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0f0f11; color: #f3f4f6; font-family: sans-serif; }
        .gold-text { color: #d4af37; }
        .gold-bg { background-color: #d4af37; }
        .gold-border { border-color: #d4af37; }
    </style>
</head>
<body class="flex flex-col min-h-screen justify-between">

    <!-- Navbar -->
    <nav class="bg-zinc-900 border-b border-zinc-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-2xl font-extrabold tracking-wider gold-text">RAM PARFUM</span>
                </a>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Katalog</a>
                    <a href="{{ route('contact') }}" class="hover:text-amber-400 transition">Konsultasi / Jual</a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.products.index') }}" class="text-xs bg-amber-500 text-black font-bold px-3 py-1.5 rounded hover:bg-amber-400 transition">Kelola Produk</a>
                            <a href="{{ route('admin.dashboard') }}" class="text-xs bg-zinc-800 text-amber-400 font-bold px-3 py-1.5 rounded hover:bg-zinc-700 transition">Dashboard Admin</a>
                        @else
                            <!-- Menu Pesanan Saya khusus Pembeli -->
                            <a href="{{ route('orders.myOrders') }}" class="hover:text-amber-400 transition flex items-center gap-1.5 font-medium">
                                <i class="fa-solid fa-bag-shopping text-amber-400"></i> Pesanan Saya
                            </a>
                        @endif

                        <span class="text-zinc-400 text-sm">Hai, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-amber-400">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm gold-bg text-zinc-950 px-4 py-2 rounded-lg font-bold hover:bg-amber-400 transition">Daftar Akun</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="mb-auto">
        @if(session('success'))
            <div class="max-w-7xl mx-auto mt-4 px-4">
                <div class="bg-emerald-900/50 border border-emerald-500 text-emerald-200 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto mt-4 px-4">
                <div class="bg-rose-900/50 border border-rose-500 text-rose-200 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-zinc-950 border-t border-zinc-800 py-6 mt-12 text-center text-zinc-500 text-sm">
        <p>&copy; {{ date('Y') }} RAM Parfum. All rights reserved.</p>
    </footer>

</body>
</html>