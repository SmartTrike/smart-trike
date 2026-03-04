@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-white  md:bg-gray-50/30  p-4 lg:p-10">
    <div class="max-w-4xl mx-auto my-auto ">

        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome, {{ auth()->user()->username }}</h1>
            <p class="text-gray-500 mt-1 text-lg">Here is your operation status for today.</p>
        </header>

        <div class="mb-10">


            @if($onRide)
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <x-heroicon-o-truck class="w-6 h-6 text-blue-600" />
                    </div>
                    <div>
                        <h3 class="text-blue-900 font-bold text-lg">On Active Ride</h3>
                        <p class="text-blue-700 text-sm">You are currently transporting passengers.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('driver.completeRide', $currentRide->id) }}" class="w-full md:w-auto">
                    @csrf
                    <button type="submit" class="w-full px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700">
                        Complete Ride
                    </button>
                </form>
            </div>

            @elseif($queuePosition === null)
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-amber-100 rounded-full mr-4">
                            <x-heroicon-o-qr-code class="w-6 h-6 text-amber-600" />
                        </div>
                        <div>
                            <h3 class="text-amber-900 font-bold text-lg">Join Queue</h3>
                            <p class="text-amber-700 text-sm">Please scan the terminal QR code to check in.</p>
                        </div>
                    </div>
                    <button id="start-scan" class="w-full md:w-auto px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition-all active:scale-95 shadow-lg shadow-gray-200 flex items-center justify-center gap-2">
                        <x-heroicon-o-camera class="w-5 h-5" />
                        Scan QR Code
                    </button>
                </div>

                <div id="qr-reader-container" class="mt-6 hidden">
                    <div id="qr-reader" class="overflow-hidden rounded-xl border-4 border-white shadow-xl"></div>
                    <button id="stop-scan" class="mt-4 w-full text-sm font-bold text-red-600 uppercase tracking-widest">Cancel Scan</button>
                </div>

                <form id="checkin-form" method="POST" action="{{ route('driver.checkin') }}" class="hidden">
                    @csrf
                </form>
            </div>

            @else

            
            <div class="bg-green-50 border border-green-100 rounded-2xl p-6 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="relative flex h-3 w-3 mr-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </div>
                    <div>
                        <h3 class="text-green-900 font-bold text-lg">Currently Active</h3>
                        <p class="text-green-700 text-sm">Position: #{{ $queuePosition }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <section class="space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-gray-400">driverInfo Profile</h2>
                    <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase"> Name</label>
                        <p class="text-gray-900 font-semibold text-lg">{{ $driverInfo->first_name }} {{ $driverInfo->last_name }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase">License No.</label>
                            <p class="text-gray-700 font-medium">{{ $driverInfo->license_number ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase">Expiry</label>
                            <p class="text-gray-700 font-medium">{{ $driverInfo->license_expiry_date ? \Carbon\Carbon::parse($driverInfo->license_expiry_date)->format('M d, Y') : '—' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-gray-400">Vehicle Details</h2>
                    <x-heroicon-o-truck class="w-4 h-4 text-gray-400" />
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">Plate Number</span>
                        <span class="font-mono font-bold text-gray-900 bg-white px-2 py-1 border border-gray-200 rounded shadow-sm">{{ $driverInfo->plate_number ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">MTOP Number</span>
                        <span class="font-semibold text-gray-900">{{ $driverInfo->mtop_number ?? 'N/A' }}</span>
                    </div>
                    <!-- <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Unit Model</span>
                        <span class="font-semibold text-gray-900">{{ $driverInfo->model }} ({{ $driverInfo->color }})</span>
                    </div> -->
                </div>
            </section>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startBtn = document.getElementById('start-scan');
        const stopBtn = document.getElementById('stop-scan');
        const readerContainer = document.getElementById('qr-reader-container');
        const checkinForm = document.getElementById('checkin-form');

        // Check if button exists (only on check-in screen)
        if (!startBtn) return;

        let html5QrCode = new Html5Qrcode("qr-reader");

        startBtn.addEventListener('click', () => {
            startBtn.classList.add('hidden');
            readerContainer.classList.remove('hidden');

            const config = {
                fps: 15,
                qrbox: {
                    width: 250,
                    height: 250
                },
                aspectRatio: 1.0
            };

            // Start camera
            html5QrCode.start({
                    facingMode: "environment"
                },
                config,
                (decodedText) => {
                    console.log("Found QR:", decodedText);
                    if (decodedText.trim() === "https://henley-neaped-unemphatically.ngrok-free.dev/queue/check-in") {
                        html5QrCode.stop().then(() => {
                            checkinForm.submit();
                        });
                    } else {
                        alert("Invalid QR Code. Please scan the check-in code.");
                    }
                }
            ).catch(err => {
                console.error("Camera error:", err);
                alert("Please ensure you are on HTTPS and have granted camera permissions.");
                resetUI();
            });
        });

        stopBtn.addEventListener('click', () => {
            html5QrCode.stop().then(() => {
                resetUI();
            }).catch(err => console.error(err));
        });

        function resetUI() {
            startBtn.classList.remove('hidden');
            readerContainer.classList.add('hidden');
        }
    });
</script>
@endsection