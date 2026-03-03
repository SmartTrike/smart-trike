<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', default: 'SMART TRIKE - Dashboard') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<body x-data="{ sidebarOpen: false }" class="bg-white min-h-screen h-screen sm:flex-col">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <main class="flex-1 h-full sm:ml-64">
        @yield('content')

        <div id="dispatchModal" class="fixed inset-0 z-100 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex items-center justify-center min-h-screen p-4">

                <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full overflow-hidden ">

                    <div class="bg-gray-900 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-white text-2xs font-black uppercase tracking-[0.2em]">Dispatch Configuration</h3>
                        <button type="button" onclick="closeDispatchModal()" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('driver.dispatch') }}" method="POST" class="p-8">
                        @csrf
                        <input type="hidden" name="driver_id" id="modal_driver_id">

                        <div class="mb-8">
                            <label class="block text-2xs font-black text-gray-400 uppercase tracking-widest mb-1">Active Driver</label>
                            <p id="modal_driver_name" class="text-2xl font-black text-gray-900 tracking-tight"></p>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-2xs font-black text-gray-400 uppercase tracking-widest mb-2">Passenger Count</label>
                                <input type="number" name="passenger_count" min="1" max="10" value="1" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white outline-none font-bold transition-all">
                            </div>


                            <div>
                                <label class="block text-2xs font-black text-gray-400 uppercase tracking-widest mb-2">Remarks</label>
                                <textarea name="remarks" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none text-sm" placeholder="Optional notes..."></textarea>
                            </div>
                        </div>

                        <div class="mt-10 flex gap-3">
                            <button type="button" onclick="closeDispatchModal()"
                                class="flex-1 px-6 py-4 bg-gray-100 text-gray-500 rounded-xl text-2xs font-black uppercase tracking-widest hover:bg-gray-200 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-6 py-4 bg-blue-600 text-white rounded-xl text-2xs font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition active:scale-95">
                                Confirm Dispatch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <script>
        function openDispatchModal(driverId, driverName) {
            document.getElementById('modal_driver_id').value = driverId;
            document.getElementById('modal_driver_name').innerText = driverName;
            document.getElementById('dispatchModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling background
        }

        function closeDispatchModal() {
            document.getElementById('dispatchModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>

</html>