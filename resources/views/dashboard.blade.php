<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel Dashboard') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen p-6 lg:p-8 flex flex-col items-center lg:justify-start">
    
    <header class="w-full lg:max-w-4xl max-w-[335px] mb-6 flex justify-between items-center">
        <h1 class="font-medium text-lg">Dashboard</h1>
        <nav class="flex gap-4">
            <a href="{{ url('/dashboard') }}" class="px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm hover:border-[#1915014a] dark:hover:border-[#62605b] text-[#1b1b18] dark:text-[#EDEDEC]">Home</a>

            <!-- Logout link -->
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                class="px-5 py-1.5 border border-transparent rounded-sm hover:border-[#19140035] dark:hover:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC]">
                Logout
            </a>

            <!-- Hidden logout form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </header>


    <main class="flex flex-col lg:flex-row w-full max-w-4xl gap-6">
        <!-- Sidebar -->
        <aside class="flex-1 bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] p-6 rounded-lg lg:rounded-tl-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <h2 class="font-medium mb-4">Quick Links</h2>
            <ul class="flex flex-col gap-2 text-sm">
                <li>Username: {{$user->name}}</li>
                <li><a href="#" class="underline text-[#f53003] dark:text-[#FF4433]">Documentation</a></li>
                <li><a href="#" class="underline text-[#f53003] dark:text-[#FF4433]">Tutorials</a></li>
                <li><a href="#" class="underline text-[#f53003] dark:text-[#FF4433]">Settings</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <section class="flex-2 bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] p-6 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <h2 class="font-medium mb-4">Statistics</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="p-4 bg-[#FDFDFC] dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)]">
                    <p class="text-sm">Users</p>
                    <h3 class="font-bold text-xl">1,234</h3>
                </div>
                <div class="p-4 bg-[#FDFDFC] dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)]">
                    <p class="text-sm">New Orders</p>
                    <h3 class="font-bold text-xl">567</h3>
                </div>
                <div class="p-4 bg-[#FDFDFC] dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)]">
                    <p class="text-sm">Revenue</p>
                    <h3 class="font-bold text-xl">$12,345</h3>
                </div>
                <div class="p-4 bg-[#FDFDFC] dark:bg-[#161615] rounded-lg shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)]">
                    <p class="text-sm">Feedback</p>
                    <h3 class="font-bold text-xl">89</h3>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
