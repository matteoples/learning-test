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
    <aside class="fixed left-0 top-0 w-[70px] lg:w-[190px] h-screen flex flex-col px-3 py-5 bg-[#FAFAFA] justify-center">

        <div class="flex items-center gap-2 py-5 pl-2">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-6">
            <h1 class="font-bold text-lg m-0 hidden lg:inline">RipetiFlow</h1>
        </div>

        <nav class="flex flex-col gap-2 text-sm">
            {{-- Dashboard --}}
            <a href="{{ url('/dashboard') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                    {{ Request::is('dashboard*') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">
                    
                    <img src="{{ asset('img/dashboard.png') }}" alt="Dashboard" class="w-5 h-5">
                    <span class="hidden lg:inline">Dashboard</span>
                </div>
            </a>

            {{-- Studenti --}}
            <a href="{{ url('/students') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                    {{ Request::is('students*') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">    

                    <img src="{{ asset('img/people.png') }}" alt="Studenti" class="w-5 h-5">
                    <span class="hidden lg:inline">Studenti</span>
                </div>
            </a>

            {{-- Calendario --}}
            <a href="{{ url('/calendar') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                    {{ Request::is('calendar*') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">

                    <img src="{{ asset('img/calendar.png') }}" alt="Calendario" class="w-5 h-5">
                    <span class="hidden lg:inline">Calendario</span>
                </div>
            </a>

            {{-- Pagamenti --}}
    {{--         <a href="# {{ url('/payments') }}"> 
    --}}            <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 pointer-events-none opacity-50
                    {{ Request::is('payments*') ? 'bg-white border border-gray-100' : 'hover:bg-[#FFFFFF]' }}">

                    <img src="{{ asset('img/coin.png') }}" alt="Pagamenti" class="w-5 h-5">
                    <span class="hidden lg:inline">Pagamenti</span>
                </div>
    {{--         </a>
    --}}
        </nav>

        <div class="mt-auto w-full">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex w-full">
                    <div class="px-3 py-3 rounded-[10px] hover:bg-[#FFFFFF] flex items-center gap-3 w-full">
                        <img src="{{ asset('img/logout.png') }}" alt="Logout" class="w-5 h-5">
                        <span class="hidden lg:inline">Logout</span>
                    </div>
                </button>
            </form>
        </div>
    </aside>



    <!-- Contenuto principale -->
    <main class="flex-1 pl-[60px] lg:pl-[180px] py-6 flex flex-col gap-6">

        @hasSection('back-button-route')
            <a href="@yield('back-button-route')"
            class="px-3 py-2 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition self-start">
                <div class="flex gap-2 items-center">
                    <img src="{{ asset('img/back.png') }}" alt="Indietro" class="w-3 h-3">
                    Indietro
                </div>
            </a>
        @endif

        <div class="bg-white border border-gray-200 rounded-[12px] flex flex-col gap-4">

            <!-- Header box: titolo + azioni -->
            <div class="flex justify-between items-center p-4 pb-0 h-[60px]">
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
