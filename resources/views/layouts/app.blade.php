<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RipetiFlow - @yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#FAFAFA] flex p-3">

    <!-- Sidebar verticale -->
    <aside class="fixed left-0 top-0 w-[200px] h-screen flex flex-col px-5 py-5 bg-[#FAFAFA]">
        <h1 class="font-bold text-lg mb-6">RipetiFlow</h1>
        <nav class="flex flex-col gap-3 text-sm">
            <a href="{{ url('/dashboard') }}" class="px-3 py-2 rounded hover:bg-[#FFFFFF]">Dashboard</a>
            <a href="{{ url('/students') }}" class="px-3 py-2 rounded hover:bg-[#FFFFFF]">Studenti</a>
            <a href="{{ url('/calendar') }}" class="px-3 py-2 rounded hover:bg-[#FFFFFF]">Calendario</a>
            <a href="{{ url('/payments') }}" class="px-3 py-2 rounded hover:bg-[#FFFFFF]">Pagamenti</a>
        </nav>
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-border-gray-200">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Contenuto principale -->
    <main class="flex-1 pl-[200px]">
        <div class="bg-white border border-gray-200 rounded-[12px] flex flex-col gap-4">
            
            <!-- Header box: titolo + azioni -->
            <div class="flex justify-between items-center p-4 pb-0">
                <h2 class="font-bold text-2xl pl-3">@yield('page-title')</h2>
                @yield('action-buttons')
            </div>


            <div class="border-t border-gray-200"></div>

            <!-- Contenuto della pagina -->
            <div class="p-6 pt-2">
                @yield('content')
            </div>
        </div>
    </main>

</body>
</html>
