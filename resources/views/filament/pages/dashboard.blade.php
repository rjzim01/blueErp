<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Section 1: Balance Cards Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Cash Balance --}}
            <div class="relative overflow-hidden rounded-xl shadow-lg p-5" style="background-color: #28a745;">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Cash Balance</p>
                        <p class="text-white text-2xl font-bold mt-1">{{ number_format($cashbalance) }}/-</p>
                    </div>
                    <div class="text-white/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/20">
                    <a href="{{ route('filament.admin.resources.balances.index') }}" class="text-white/90 text-sm hover:text-white flex items-center gap-1">
                        View Details
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- City Bank Balance --}}
            <div class="relative overflow-hidden rounded-xl shadow-lg p-5" style="background-color: #17a2b8;">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-white/80 text-sm font-medium">City Bank Balance</p>
                        <p class="text-white text-2xl font-bold mt-1">{{ number_format($citybalance) }}/-</p>
                    </div>
                    <div class="text-white/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/20">
                    <a href="{{ route('filament.admin.resources.balances.index') }}" class="text-white/90 text-sm hover:text-white flex items-center gap-1">
                        View Details
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- DBBL Balance --}}
            <div class="relative overflow-hidden rounded-xl shadow-lg p-5" style="background-color: #ffc107;">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-white/80 text-sm font-medium">DBBL Balance</p>
                        <p class="text-white text-2xl font-bold mt-1">{{ number_format($dbblbalance) }}/-</p>
                    </div>
                    <div class="text-white/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/20">
                    <a href="{{ route('filament.admin.resources.balances.index') }}" class="text-white/90 text-sm hover:text-white flex items-center gap-1">
                        View Details
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Islami Bank Balance --}}
            <div class="relative overflow-hidden rounded-xl shadow-lg p-5" style="background-color: #6f42c1;">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Islami Bank</p>
                        <p class="text-white text-2xl font-bold mt-1">{{ number_format($islamibankbalance) }}/-</p>
                    </div>
                    <div class="text-white/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/20">
                    <a href="{{ route('filament.admin.resources.balances.index') }}" class="text-white/90 text-sm hover:text-white flex items-center gap-1">
                        View Details
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Bank Asia Balance --}}
            <div class="relative overflow-hidden rounded-xl shadow-lg p-5" style="background-color: #343a40;">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Bank Asia</p>
                        <p class="text-white text-2xl font-bold mt-1">{{ number_format($bankasiabalance) }}/-</p>
                    </div>
                    <div class="text-white/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/20">
                    <a href="{{ route('filament.admin.resources.balances.index') }}" class="text-white/90 text-sm hover:text-white flex items-center gap-1">
                        View Details
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Section 2: Stats Info Boxes --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Available Products --}}
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 pl-20">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #17a2b8;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Available Products</p>
                <p class="text-gray-900 dark:text-white text-2xl font-bold">{{ number_format($products) }}</p>
            </div>

            {{-- Total Available Barcodes --}}
            <a href="{{ route('filament.admin.resources.product-archives.index') }}" class="block">
                <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 pl-20 hover:shadow-lg transition-shadow">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #dc3545;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Available Barcodes</p>
                    <p class="text-gray-900 dark:text-white text-2xl font-bold">{{ number_format($barcodes) }}</p>
                </div>
            </a>

            {{-- Number of Today Sell --}}
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 pl-20">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #28a745;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Number of Today Sell</p>
                <p class="text-gray-900 dark:text-white text-2xl font-bold">{{ number_format($todaysell) }}</p>
            </div>

            {{-- Number of Today Returns --}}
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 pl-20">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #ffc107;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Number of Today Returns</p>
                <p class="text-gray-900 dark:text-white text-2xl font-bold">{{ number_format($todayreturn) }}</p>
            </div>
        </div>

        {{-- Section 3: POS Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {{-- Today POS Sell --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4" style="border-left-color: #28a745;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 dark:bg-green-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" style="color: #28a745;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Today POS Sell</p>
                        <p class="text-gray-900 dark:text-white text-xl font-bold">{{ number_format($todays_sell_amount) }}/-</p>
                    </div>
                </div>
            </div>

            {{-- Today POS Returns --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4" style="border-left-color: #dc3545;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-red-100 dark:bg-red-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" style="color: #dc3545;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Today POS Returns</p>
                        <p class="text-gray-900 dark:text-white text-xl font-bold">{{ number_format($todays_return_amount) }}/-</p>
                    </div>
                </div>
            </div>

            {{-- Today Net POS Sell --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4" style="border-left-color: #ffc107;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" style="color: #ffc107;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Today Net POS Sell</p>
                        <p class="text-gray-900 dark:text-white text-xl font-bold">{{ number_format($net_sell_amount) }}/-</p>
                    </div>
                </div>
            </div>

            {{-- Sold Items --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4" style="border-left-color: #28a745;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 dark:bg-green-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" style="color: #28a745;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Sold Items</p>
                        <p class="text-gray-900 dark:text-white text-xl font-bold">{{ number_format($todays_sell_qtt) }}</p>
                    </div>
                </div>
            </div>

            {{-- Return Items --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4" style="border-left-color: #dc3545;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-red-100 dark:bg-red-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" style="color: #dc3545;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Return Items</p>
                        <p class="text-gray-900 dark:text-white text-xl font-bold">{{ number_format($todays_return_qtt) }}</p>
                    </div>
                </div>
            </div>

            {{-- Net Sell Items --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4" style="border-left-color: #ffc107;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" style="color: #ffc107;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Net Sell Items</p>
                        <p class="text-gray-900 dark:text-white text-xl font-bold">{{ number_format($net_sell_qtt) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4: Action Buttons Row --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('filament.admin.resources.customers.index') }}" class="inline-flex items-center px-5 py-3 rounded-full font-semibold text-white shadow-md hover:shadow-lg transition-all" style="background-color: #28a745;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Customer
            </a>
            <a href="#" class="inline-flex items-center px-5 py-3 rounded-full font-semibold text-white shadow-md hover:shadow-lg transition-all" style="background-color: #ffc107;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Daraz Monthly
            </a>
            <a href="/admin/pos/create" class="inline-flex items-center px-5 py-3 rounded-full font-semibold text-white shadow-md hover:shadow-lg transition-all" style="background-color: #17a2b8;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Go To POS
            </a>
            <a href="{{ route('filament.admin.resources.stocks.index') }}" class="inline-flex items-center px-5 py-3 rounded-full font-semibold text-white shadow-md hover:shadow-lg transition-all" style="background-color: #007bff;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Go To Stock Report
            </a>
            <a href="{{ route('filament.admin.resources.stock-entries.create') }}" class="inline-flex items-center px-5 py-3 rounded-full font-semibold text-white shadow-md hover:shadow-lg transition-all" style="background-color: #28a745;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Go To Old Stock Entry
            </a>
            <a href="{{ route('filament.admin.resources.balances.index') }}" class="inline-flex items-center px-5 py-3 rounded-full font-semibold text-white shadow-md hover:shadow-lg transition-all" style="background-color: #dc3545;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Go To Outlet Wise Balance
            </a>
        </div>

        {{-- Section 5 & 7: Date Range Wise + Outlet Wise Summary Report (Combined Card) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Date Range Wise Summary Report</h3>
            
            {{-- Date Range Picker --}}
            <div class="flex flex-wrap items-end gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                    <input type="date" wire:model="fromDate" class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
                    <span class="text-gray-500 dark:text-gray-400">to</span>
                    <input type="date" wire:model="toDate" class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
                    <button wire:click="loadDistributionData" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update</button>
                </div>
            </div>

            {{-- Distribution Stats (Counts) --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Production</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['total_prduction'] ?? 0) }}</p>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-yellow-700 dark:text-yellow-400">Warehouse</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['total_warehouse'] ?? 0) }}</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-blue-700 dark:text-blue-400">Transfer Channel</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['total_transfer'] ?? 0) }}</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-green-700 dark:text-green-400">Outlet Stock</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['total_outlet_stock'] ?? 0) }}</p>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-purple-700 dark:text-purple-400">POS Sell</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['total_sold'] ?? 0) }}/-</p>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-purple-700 dark:text-purple-400">Order Sell</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['total_order'] ?? 0) }}/-</p>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-orange-700 dark:text-orange-400">Damaged</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['total_damaged'] ?? 0) }}</p>
                </div>
                <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-red-700 dark:text-red-400">Stock Error</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['stock_error'] ?? 0) }}</p>
                </div>
            </div>

            {{-- Grouped Totals (Amount) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-indigo-700 dark:text-indigo-400">Total Stock Amount</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($distribution['warehouse_amount'] ?? 0) }}/-</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Warehouse Total</p>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-emerald-700 dark:text-emerald-400">Total Sell</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format(($distribution['total_sold'] ?? 0) + ($distribution['total_order'] ?? 0)) }}/-</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">POS + Order</p>
                </div>
                <div class="bg-rose-50 dark:bg-rose-900/30 rounded-lg p-4 text-center">
                    <p class="text-sm text-rose-700 dark:text-rose-400">Total Loss</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format(($distribution['total_damaged'] ?? 0) + ($distribution['stock_error'] ?? 0)) }}/-</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Damaged + Error</p>
                </div>
            </div>

            <hr class="my-6 border-gray-200 dark:border-gray-700">

            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Outlet Wise Summary Report</h3>
            
            {{-- Outlet Wise Summary Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">SL</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Outlet</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">POS</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Return</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Cancel</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Net Sell</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Expenses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($outlet_wise_sell as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $item['name'] }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($item['pos_sell'], 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($item['order_sell'], 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($item['return'], 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($item['order_cancelled'], 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($item['net_sell'], 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($item['expense'], 0) }}/-</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                        @if(count($outlet_wise_sell) > 0)
                            <tr class="bg-gray-100 dark:bg-gray-800 font-semibold">
                                <td colspan="2" class="px-4 py-3 text-gray-900 dark:text-gray-100">Total</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($outlet_wise_report_summery['pos_ttl'] ?? 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($outlet_wise_report_summery['order_ttl'] ?? 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($outlet_wise_report_summery['ret_ttl'] ?? 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($outlet_wise_report_summery['cancel_ttl'] ?? 0) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format(($outlet_wise_report_summery['pos_ttl'] ?? 0) + ($outlet_wise_report_summery['order_ttl'] ?? 0) - ($outlet_wise_report_summery['ret_ttl'] ?? 0) - ($outlet_wise_report_summery['cancel_ttl'] ?? 0)) }}/-</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ number_format($outlet_wise_report_summery['expense_ttl'] ?? 0) }}/-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section 6: Net Sell of Last 30 Days Chart (Separate Card) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Net Sell of Last 30 Days</h3>
            <div id="salesChart" class="w-full h-80"></div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chart_data);
            const isDark = document.documentElement.classList.contains('dark');
            
            const chartOptions = {
                chart: { 
                    type: 'column',
                    backgroundColor: isDark ? '#1f2937' : '#ffffff',
                    style: { fontFamily: 'inherit' }
                },
                title: { 
                    text: 'Net Sell of Last 30 Days',
                    style: { color: isDark ? '#ffffff' : '#111827' }
                },
                subtitle: { 
                    text: 'Source: BLUE ERP V3',
                    style: { color: isDark ? '#9ca3af' : '#6b7280' }
                },
                xAxis: {
                    categories: chartData.dates,
                    crosshair: true,
                    labels: { style: { color: isDark ? '#9ca3af' : '#6b7280' } },
                    lineColor: isDark ? '#374151' : '#e5e7eb',
                    tickColor: isDark ? '#374151' : '#e5e7eb'
                },
                yAxis: {
                    min: 0,
                    title: { text: 'Sell (BDT)', style: { color: isDark ? '#9ca3af' : '#6b7280' } },
                    labels: { style: { color: isDark ? '#9ca3af' : '#6b7280' } },
                    gridLineColor: isDark ? '#374151' : '#e5e7eb'
                },
                tooltip: {
                    backgroundColor: isDark ? '#1f2937' : '#ffffff',
                    borderColor: isDark ? '#374151' : '#e5e7eb',
                    style: { color: isDark ? '#ffffff' : '#111827' },
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} BDT</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                legend: {
                    itemStyle: { color: isDark ? '#9ca3af' : '#6b7280' },
                    itemHoverStyle: { color: isDark ? '#ffffff' : '#111827' }
                },
                series: [
                    { name: 'POS Sell (Net)', data: chartData.pos, color: '#8b5cf6' },
                    { name: 'Order Sell', data: chartData.order, color: '#3b82f6' },
                    { name: 'Net Sell', data: chartData.net, color: '#22c55e' }
                ]
            };
            
            if (chartData && chartData.dates) {
                Highcharts.chart('salesChart', chartOptions);
            }
        });
    </script>
    @endpush
</x-filament-panels::page>
