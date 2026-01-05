<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RipetiFlow - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-odd flex p-3">

    <div class="fixed bottom-0 left-0 w-full h-[70px] xl:w-[180px]
        sm:top-0 sm:left-0 sm:w-[65px] sm:h-screen
        bg-odd
        flex sm:flex-col 
        items-center justify-around sm:justify-start 
        gap-5 sm:gap-2
        z-50">

        <div class="flex items-center gap-2 py-5 pl-2 hidden sm:flex">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-6">
            <h1 class="primary-text font-bold text-lg m-0 hidden xl:inline">RipetiFlow</h1>
        </div>


        <a href="{{ url('/dashboard') }}" class="w-full block px-2">
            <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 w-full justify-center sm:justify-start {{ Request::is('dashboard*') ? 'bg-even box-border border' : 'bg-odd' }} ">
                
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span class="primary-text hidden xl:inline">Dashboard</span>
            </div>
        </a>

        <a href="{{ url('/students') }}" class="w-full block px-2">
            <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 w-full justify-center sm:justify-start {{ Request::is('students*') ? 'bg-even box-border border' : 'bg-odd' }}">    

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="8a8a8aff" stroke="8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="primary-text hidden xl:inline">Studenti</span>
            </div>
        </a>


        <a href="{{ url('/calendar') }}" class="w-full block px-2">
            <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 w-full justify-center sm:justify-start {{ Request::is('calendar*') ? 'bg-even box-border border' : 'bg-odd' }}">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>

                <span class="primary-text hidden xl:inline">Calendario</span>
            </div>
        </a>
        

    </div>


    <!-- Sidebar verticale -->
    {{-- <aside class="fixed left-0 top-0 w-[70px] xl:w-[190px] h-screen flex flex-col px-3 py-5 justify-center">

        <div class="flex items-center gap-2 py-5 pl-2">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-6">
            <h1 class="primary-text font-bold text-lg m-0 hidden xl:inline">RipetiFlow</h1>
        </div>

        <nav class="flex flex-col gap-2 text-sm">
            {{-- Dashboard --}
            <a href="{{ url('/dashboard') }}">
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3
                    {{ Request::is('dashboard*') ? 'bg-even box-border border' : 'bg-odd' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span class="primary-text hidden xl:inline">Dashboard</span>
                </div>
            </a>


            {{-- Studenti --}
            <a href="{{ url('/students') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                    {{ Request::is('students*') ? 'bg-even box-border border' : 'bg-odd' }}">    

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="8a8a8aff" stroke="8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span class="primary-text hidden xl:inline">Studenti</span>
                </div>
            </a>

            {{-- Calendario --}
            <a href="{{ url('/calendar') }}"> 
                <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 
                    {{ Request::is('calendar*') ? 'bg-even box-border border' : 'bg-odd' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>

                    <span class="primary-text hidden xl:inline">Calendario</span>
                </div>
            </a>
        </nav>

        
        <div class="mt-auto w-full">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex w-full cursor-pointer">
                    <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 hover:bg-even transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9"/>
                        </svg>
                        <span class="primary-text hidden xl:inline">Logout</span>
                    </div>
                </button>
            </form>
        </div>
    </aside> --}}

    <!-- Contenuto principale -->
    <main class="flex-1 sm:pl-[60px] xl:pl-[180px] py-6 flex flex-col gap-6">

        @hasSection('back-button-route')
            <a href="@yield('back-button-route')"
            class="secondary-button self-start">
                <div class="flex gap-2 items-center">
                    <img src="{{ asset('img/back.png') }}" alt="Indietro" class="w-3 h-3">
                    Indietro
                </div>
            </a>
        @endif

        <div class="bg-even border box-border rounded-[12px] flex flex-col gap-4">

            <!-- Header box: titolo + azioni -->
            <div class="flex justify-between items-center p-4 pb-0 h-[60px]">
                <h2 class="font-bold text-2xl pl-3 primary-text">@yield('page-title')</h2>
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
