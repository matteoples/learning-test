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
    <aside class="fixed left-0 top-0 w-[190px] h-screen flex flex-col px-3 py-5 bg-[#FAFAFA]">

        <div class="flex items-center gap-2 py-5 pl-2">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-6">
            <h1 class="font-bold text-lg m-0">RipetiFlow</h1>
        </div>

        
        
        <nav class="flex flex-col gap-2 text-sm">
            
            <a href="{{ url('/dashboard') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                        {{ Request::is('dashboard') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">
                    
                        <img src="{{ asset('img/dashboard.png') }}" alt="Modifica" class="w-5 h-5">
                    Dashboard
                </div>
            </a>

            <a href="{{ url('/students') }}"> 
                    <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                        {{ Request::is('students') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">    

                    <img src="{{ asset('img/people.png') }}" alt="Modifica" class="w-5 h-5">
                    Studenti
                </div>
            </a>

            <a href="{{ url('/calendar') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                        {{ Request::is('calendar') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">

                    <img src="{{ asset('img/calendar.png') }}" alt="Modifica" class="w-5 h-5">
                    Calendario
                </div>
            </a>

            <a href="{{ url('/payments') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                        {{ Request::is('payments') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">

                    <img src="{{ asset('img/coin.png') }}" alt="Modifica" class="w-5 h-5">
                    Pagamenti
                </div>
            </a>
            
            
        </nav>
        <div class="mt-auto w-full">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex">
                    <div class="px-3 py-3 rounded-[10px] hover:bg-[#FFFFFF] flex items-center gap-3">
                        <img src="{{ asset('img/logout.png') }}" alt="Modifica" class="w-5 h-5">
                        Logout
                    </div>
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenuto principale -->
    <main class="flex-1 pl-[180px]">
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
