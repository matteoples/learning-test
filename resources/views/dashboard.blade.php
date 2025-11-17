@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<main class="w-full flex flex-col md:flex-row lg:flex-row gap-6">

    <!-- Main Content -->
    <section class="w-full bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] p-6 rounded-lg shadow">
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
@endsection
