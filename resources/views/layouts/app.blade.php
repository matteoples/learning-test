@php
use App\Enums\FontWeight as FW;
@endphp

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RipetiFlow - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-odd flex p-3">

    <div class="fixed bottom-0 left-0 w-full h-[80px] xl:w-[180px]
        sm:top-0 sm:left-0 sm:w-[65px] sm:h-screen
        bg-odd
        flex sm:flex-col 
        items-center justify-start 
        gap-5 sm:gap-2
        z-50">

        <div class="flex items-center gap-2 py-5 pl-2 hidden sm:flex">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-6">
            <h1 class="primary-text font-bold text-lg m-0 hidden xl:inline">RipetiFlow</h1>
        </div>


        <a href="{{ url('/dashboard') }}" class="w-full block px-2">
            <x-box-container class="sm:justify-start {{ Request::is('dashboard*') ? 'bg-even box-border border' : 'bg-odd' }}">
                <div class="flex flex-row items-center gap-2">
                    <x-icon name="dashboard" color="var(--primary-text)" />
                    <x-text class="hidden xl:inline">Dashboard</x-text>
                </div>
            </x-box-container>
        </a>

        <a href="{{ url('/students') }}" class="w-full block px-2">
            <x-box-container class="sm:justify-start {{ Request::is('students*') ? 'bg-even box-border border' : 'bg-odd' }}">
                <div class="flex flex-row items-center gap-2">
                    <x-icon name="students" color="var(--primary-text)" />
                    <x-text class="hidden xl:inline">Studenti</x-text>
                </div>
            </x-box-container>
        </a>

        <a href="{{ url('/calendar') }}" class="w-full block px-2">
            <x-box-container class="sm:justify-start {{ Request::is('calendar*') ? 'bg-even box-border border' : 'bg-odd' }}">
                <div class="flex flex-row items-center gap-2">
                    <x-icon name="calendar" color="var(--primary-text)" />
                    <x-text class="hidden xl:inline">Calendario</x-text>
                </div>
            </x-box-container>
        </a>

        <a href="{{ url('/settings') }}" class="w-full block px-2">
            <x-box-container class="sm:justify-start {{ Request::is('settings*') ? 'bg-even box-border border' : 'bg-odd' }}">
                <div class="flex flex-row items-center gap-2">
                    <x-icon name="settings" color="var(--primary-text)"/>
                    <x-text class="hidden xl:inline">Impostazioni</x-text>
                </div>
            </x-box-container>
        </a>
        
    </div>


    <!-- Contenuto principale -->
    <main class="flex-1 sm:pl-[60px] xl:pl-[180px] py-6 flex flex-col gap-6">

        @hasSection('back-button-route')
            <a href="@yield('back-button-route')" class="secondary-button self-start">
                <x-button variant="secondary" icon="back"> Indietro </x-button>
            </a>
        @endif

        <div class="bg-even border box-border rounded-[12px] flex flex-col gap-4">

            <!-- Header box: titolo + azioni -->
            <div class="flex justify-between items-center p-4 pb-0 h-[60px]">
                <x-large-title> @yield('page-title') </x-large-title>
                @yield('action-buttons')
            </div>

            <div class="border-t box-border"></div>
            <!-- Contenuto della pagina -->
            <div class="p-6 pt-2">
                @yield('content')
            </div>

            

        </div>

        <div class="h-[30px]"></div> <!-- spazio in basso -->
    </main>
    
    
</body>
</html>
