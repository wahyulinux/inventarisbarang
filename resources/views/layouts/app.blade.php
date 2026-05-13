<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Inventaris Barang') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0d6efd',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white transition duration-300 transform md:relative md:translate-x-0 md:static md:inset-0">
            <div class="flex items-center justify-between px-6 py-4">
                <span class="text-xl font-bold">Inventaris</span>
                <button @click="sidebarOpen = false" class="md:hidden text-gray-300 hover:text-white">
                    <i class="bi bi-x-lg text-2xl"></i>
                </button>
            </div>
            
            <nav class="mt-4 px-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-speedometer2 mr-3"></i> Dashboard
                </a>
                <a href="{{ route('items.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('items*') ? 'active' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }} {{ request()->is('items*') ? 'bg-blue-600 text-white' : '' }}">
                    <i class="bi bi-box mr-3"></i> Barang
                </a>
                @if(!auth()->user()->warehouse_id)
                <a href="{{ route('warehouses.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('warehouses*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-house mr-3"></i> Gudang
                </a>
                @endif
                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('categories*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-tags mr-3"></i> Kategori
                </a>
                <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('transactions*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-arrow-left-right mr-3"></i> Transaksi
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('users*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-people mr-3"></i> Kelola User
                </a>
                @endif

                <a href="{{ route('password.edit') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('password*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-shield-lock mr-3"></i> Ganti Password
                </a>
                
                <div class="pt-10">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-3 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-500 transition">
                            <i class="bi bi-box-arrow-right mr-3"></i> Logout
                        </a>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none md:hidden mr-4">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium border border-gray-200">
                        {{ auth()->user()->username }} ({{ ucfirst(auth()->user()->role) }}{{ auth()->user()->warehouse ? ' - ' . auth()->user()->warehouse->name : '' }})
                    </span>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

