@extends('layouts.app')
@section('content')

<nav class="bg-neutral-primary fixed w-full z-20 top-0 start-0 border-b border-default">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('logo.png') }}" width="50" height="50" alt="Barangay Ligue Logo" class="shadow-sm rounded-full">
            <div class="flex flex-col">
                <span class="self-center text-xl text-heading font-bold whitespace-nowrap leading-none">Smart Trike</span>
                <span class="text-2xs uppercase tracking-tighter text-gray-500 font-semibold mt-2">Brgy. Ligue, Bayambang</span>
            </div>
        </a>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-default rounded-base md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-neutral-primary">
                <li>
                    <a id="features-link" href="#features" class="block py-2 px-3 text-heading rounded hover:text-[#0053A1] md:p-0">Features</a>
                </li>
                <li>
                    <a href="/login" class="p-2 px-6 text-sm rounded bg-[#0053A1] hover:bg-[#0053A1]/90 text-white transition duration-200">Access Portal</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="max-w-screen-2xl mx-auto flex-1 flex flex-col overflow-y-auto">
    <section class="h-screen min-h-0 bg-gray-50 grid md:grid-cols-2 px-4">
        <div class="flex flex-col p-8 justify-center">
            <!-- <div class="inline-flex items-center space-x-2 bg-blue-50 text-[#0053A1] px-3 py-1 rounded-full w-fit mb-4 border border-blue-100">
                <span class="text-2xs font-bold uppercase tracking-wider">Official Terminal System</span>
            </div> -->
            <h1 class="text-2xl md:text-5xl text-gray-800 font-bold text-left tracking-tight leading-tight">
                Tricycle Monitoring & Management System
            </h1>
            <p class="text-lg font-semibold text-[#0053A1] mt-2">Barangay Ligue, Bayambang, Pangasinan</p>
            <p class="font-normal text-gray-600 text-sm md:text-base mt-4 max-w-md">
                A digital solution for a safer and more organized tricycle terminal. Featuring QR-based check-ins, fair queue dispatching, and community lost & found reporting.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <a href="/login" class="px-8 py-4 rounded-xl text-white text-sm font-bold shadow-lg shadow-blue-200 hover:bg-[#0053A1]/90 flex items-center justify-center bg-[#0053A1] transition duration-200">
                    Access Portal
                </a>
            </div>
        </div>
        <div class="hidden md:flex items-center justify-center relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100/50 to-transparent rounded-full filter blur-3xl opacity-50"></div>
        </div>
    </section>

    <section id="features" class="h-auto py-16 md:py-24 items-center justify-center flex flex-col bg-white p-8 md:px-24">
        <h3 class="text-[#0053A1] font-bold text-center text-sm tracking-widest uppercase">Features</h3>
        <h1 class="text-semibold text-gray-900 text-3xl text-center py-8">Empowering Ligue's Transport Operations</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-7">
            <div class="group h-auto md:h-44 items-start justify-center bg-white rounded-3xl border border-gray-100 p-6 flex flex-col hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="mb-4 p-3 bg-blue-50 rounded-2xl group-hover:bg-[#0053A1] transition-colors">
                    <x-heroicon-o-qr-code class="h-6 text-[#0053A1] group-hover:text-white" />
                </div>
                <p class="font-bold text-gray-800 text-base">QR Check-in</p>
                <p class="text-sm text-gray-600 mt-1">Drivers join the terminal queue instantly by scanning the station's QR code.</p>
            </div>

            <div class="group h-auto md:h-44 items-start justify-center bg-white rounded-3xl border border-gray-100 p-6 flex flex-col hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="mb-4 p-3 bg-blue-50 rounded-2xl group-hover:bg-[#0053A1] transition-colors">
                    <x-heroicon-o-archive-box class="h-6 text-[#0053A1] group-hover:text-white" />
                </div>
                <p class="font-bold text-gray-800 text-base">Lost & Found</p>
                <p class="text-sm text-gray-600 mt-1">A dedicated system for reporting and retrieving items left behind by passengers.</p>
            </div>

            <div class="group h-auto md:h-44 items-start justify-center bg-white rounded-3xl border border-gray-100 p-6 flex flex-col hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="mb-4 p-3 bg-blue-50 rounded-2xl group-hover:bg-[#0053A1] transition-colors">
                    <x-pepicon-people class="h-6 text-[#0053A1] group-hover:text-white" />
                </div>
                <p class="font-bold text-gray-800 text-base">Smart Dispatching</p>
                <p class="text-sm text-gray-600 mt-1">Real-time queue monitoring ensures fair rotation for all Brgy. Ligue drivers.</p>
            </div>

            <div class="group h-auto md:h-44 items-start justify-center bg-white rounded-3xl border border-gray-100 p-6 flex flex-col hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="mb-4 p-3 bg-blue-50 rounded-2xl group-hover:bg-[#0053A1] transition-colors">
                    <x-heroicon-o-identification class="h-6 text-[#0053A1] group-hover:text-white" />
                </div>
                <p class="font-bold text-gray-800 text-base">Driver Profiles</p>
                <p class="text-sm text-gray-600 mt-1">Secure database of MTOPs, licenses, and vehicle details for community safety.</p>
            </div>

            <div class="group h-auto md:h-44 items-start justify-center bg-white rounded-3xl border border-gray-100 p-6 flex flex-col hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="mb-4 p-3 bg-blue-50 rounded-2xl group-hover:bg-[#0053A1] transition-colors">
                    <x-heroicon-o-clipboard-document-list class="h-6 text-[#0053A1] group-hover:text-white" />
                </div>
                <p class="font-bold text-gray-800 text-base">Ride Analytics</p>
                <p class="text-sm text-gray-600 mt-1">Automated logs of daily trips and terminal activity for better planning.</p>
            </div>

            <div class="group h-auto md:h-44 items-start justify-center bg-white rounded-3xl border border-gray-100 p-6 flex flex-col hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="mb-4 p-3 bg-blue-50 rounded-2xl group-hover:bg-[#0053A1] transition-colors">
                    <x-heroicon-o-device-phone-mobile class="h-6 text-[#0053A1] group-hover:text-white" />
                </div>
                <p class="font-bold text-gray-800 text-base">Mobile Optimized</p>
                <p class="text-sm text-gray-600 mt-1">Easily accessible for drivers and dispatchers using any smartphone.</p>
            </div>
        </div>
    </section>
</main>

<footer class="bg-gray-50 border-t border-gray-200">
    <div class="mx-auto w-full max-w-7xl p-8">
        <div class="md:flex md:justify-between items-center">
            <div class="mb-2 md:mb-0">
                <span class="text-[#0053A1] text-2xl font-black tracking-tighter">SMART TRIKE</span>
                <p class="text-xs text-gray-500 font-medium">Barangay Ligue Terminal Management</p>
            </div>
            <div class="text-sm text-gray-500">
                Bayambang, Pangasinan
            </div>
        </div>
        <hr class="my-8 border-gray-200" />
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-sm text-gray-400">© 2026 Smart Trike Project. All Rights Reserved.</span>
     
        </div>
    </div>
</footer>
@endsection