@extends('layouts.app')
@section('content')


<nav class="bg-neutral-primary fixed w-full z-20 top-0 start-0 border-b border-default">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-7" alt="Flowbite Logo"> -->
               <img src="{{ asset('logo.png') }}" width="50" height="50" alt="Logo" class=" shadow-sm z-50 -left-3 rounded-full">
               
            <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">Smart Trike</span>
        </a>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-default rounded-base bg-neutral-secondary-soft md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-neutral-primary">
                <li>
                    <a id="features-link" href="#features" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Features</a>
                </li>
                <li>
                    <a href="/login" class=" p-2 px-4 text-sm rounded bg-[#0053A1] hover:bg-bg-[#0053A1]/90 text-white  ">Access Portal</a>

                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="  max-w-screen-2xl mx-auto flex-1 flex flex-col overflow-y-auto">
    <section class="h-screen min-h-0 bg-gray-50 grid md:grid-cols-2 px-4">
        <div class="flex flex-col p-8 justify-center ">
            <h1 class="text-2xl md:text-4xl text-gray-800 font-medium text-left tracking-wider"><span class="font-bold text-[#0053A1]">SMART TRIKE: </span>
                Automated Tricycle Terminal Monitoring and Management System
            </h1>
            <p class="font-normal text-gray-600 text-sm md:text-base mt-2">Automate dispatching, track drivers, and monitor operations — all in one system.</p>
            <a href="/login" class="px-4 py-2 rounded mt-4 text-white text-sm font-bold shadow-xs hover:bg-bg-[#0053A1]/90 flex items-center justify-center bg-[#0053A1]  transition duration-200 w-42">Access Portal</a>
        </div>
        <div class="hidden md:flex">

        </div>

    </section>
    <section id="features" class="h-auto md:h-screen min-h-0 items-center justify-center flex flex-col bg-white p-8 md:px-24">
        <h3 class="text-[#0053A1] font-bold text-center text-sm">FEATURES</h3>
        <h1 class="text-semibold text-gray-900 text-3xl text-center py-8">Everything You Need for Efficient Terminal Management</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-7">
            <div class="h-auto md:h-36 items-start justify-center bg-gray-50 rounded-2xl border border-gray-200 p-4 flex flex-col">
                <div class="h-8">
                    <x-pepicon-people class="h-6 text-[#0053A1]" />
                </div>
                <p class="font-bold md:h-8  text-gray-800 text-base">
                    Real-time Queue
                </p>
                <p class="text-sm  text-gray-700">Real-time rotation queue for fair dispatching</p>
            </div>
            <div class="h-auto md:h-36 items-start justify-center bg-gray-50 rounded-2xl border border-gray-200 p-4 flex flex-col">
                <div class="h-8">
                    <x-clarity-license-solid class="h-6 text-[#0053A1]" />

                </div>
                <p class="font-bold md:h-8  text-gray-800 text-base">
                    Driver Accounts
                </p>
                <p class="text-sm  text-gray-700">Driver accounts with availability tracking</p>
            </div>
            <div class="h-auto md:h-36 items-start justify-center bg-gray-50 rounded-2xl border border-gray-200 p-4 flex flex-col">
                <div class="h-8">
                    <x-heroicon-o-shield-check class="h-6 text-[#0053A1]" />

                </div>
                <p class="font-bold md:h-8  text-gray-800 text-base">
                    Compliance Monitoring
                </p>
                <p class="text-sm  text-gray-700">Compliance and violation monitoring</p>
            </div>
            <div class="h-auto md:h-36 items-start justify-center bg-gray-50 rounded-2xl border border-gray-200 p-4 flex flex-col">
                <div class="h-8">
                    <x-gmdi-color-lens-o class="h-6 text-[#0053A1]" />

                </div>
                <p class="font-bold md:h-8  text-gray-800 text-base">
                    Color-coded schedules
                </p>
                <p class="text-sm  text-gray-700"> Color-coded schedule for easy planning</p>
            </div>
            <div class="h-auto md:h-36 items-start justify-center bg-gray-50 rounded-2xl border border-gray-200 p-4 flex flex-col">
                <div class="h-8">
                    <x-ri-layout-2-line class="h-6 text-[#0053A1]" />

                </div>
                <p class="font-bold md:h-8  text-gray-800 text-base">
                    User Friendly
                </p>
                <p class="text-sm  text-gray-700"> Simple, intuitive interface for dispatchers and admins</p>
            </div>
            <div class="h-auto md:h-36 items-start justify-center bg-gray-50 rounded-2xl border border-gray-200 p-4 flex flex-col">
                <div class="h-8">
                    <x-tabler-report class="h-6 text-[#0053A1]" />

                </div>
                <p class="font-bold md:h-8  text-gray-800 text-base">
                    Reporting & Analytics
                </p>
                <p class="text-sm  text-gray-700">Generate reports on trips, earnings, and terminal activity to make data-driven decisions</p>
            </div>
        </div>
    </section>
</main>


<footer class="bg-neutral-primary-soft ">
    <div class="mx-auto w-full max-w-7xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="https://flowbite.com/" class="flex ">
                    <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-7 me-3" alt="FlowBite Logo" /> -->
                    <span class="text-heading self-center text-2xl font-semibold whitespace-nowrap">SMART TRIKE</span>

                </a>
            </div>

        </div>
        <hr class="my-6 border-default sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-body sm:text-center">© 2025 Smart Trike. All Rights Reserved.
            </span>

        </div>
    </div>
</footer>
@endsection

@section('scripts')
<script>

</script>
@endsection