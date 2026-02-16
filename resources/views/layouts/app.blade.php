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
                
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--primary-text)" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                </svg>


                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg> --}}
                <span class="primary-text hidden xl:inline">Dashboard</span>
            </div>
        </a>

        <a href="{{ url('/students') }}" class="w-full block px-2">
            <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 w-full justify-center sm:justify-start {{ Request::is('students*') ? 'bg-even box-border border' : 'bg-odd' }}">    

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--primary-text)" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>


                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="8a8a8aff" stroke="8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg> --}}
                <span class="primary-text hidden xl:inline">Studenti</span>
            </div>
        </a>


        <a href="{{ url('/calendar') }}" class="w-full block px-2">
            <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 w-full justify-center sm:justify-start {{ Request::is('calendar*') ? 'bg-even box-border border' : 'bg-odd' }}">


                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--primary-text)" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>



                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8a8a8aff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg> --}}

                <span class="primary-text hidden xl:inline">Calendario</span>
            </div>
        </a>

        <a href="{{ url('/settings') }}" class="w-full block px-2">
            <div class="px-3 py-3 rounded-[7px] flex items-center gap-3 w-full justify-center sm:justify-start {{ Request::is('settings*') ? 'bg-even box-border border' : 'bg-odd' }}">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--primary-text)" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                <span class="primary-text hidden xl:inline">Impostazioni</span>
            </div>
        </a>
        

    </div>


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
