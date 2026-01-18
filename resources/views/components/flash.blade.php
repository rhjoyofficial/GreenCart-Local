@if (session('success') || session('error') || session('warning') || session('info'))
    <div class="fixed top-4 right-4 z-50 max-w-md w-full">
        @foreach (['success', 'error', 'warning', 'info'] as $type)
            @if (session($type))
                <div class="mb-2 animate-slide-up">
                    <div
                        class="flex items-center justify-between p-4 rounded-lg shadow-lg border-l-4 
                        @if ($type == 'success') bg-green-50 border-green-500 text-green-800
                        @elseif($type == 'error') bg-red-50 border-red-500 text-red-800
                        @elseif($type == 'warning') bg-yellow-50 border-yellow-500 text-yellow-800
                        @else bg-blue-50 border-blue-500 text-blue-800 @endif">
                        <div class="flex items-center space-x-3">
                            @if ($type == 'success')
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @elseif($type == 'error')
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @elseif($type == 'warning')
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                            <div>
                                <p class="font-medium">{{ ucfirst($type) }}</p>
                                <p class="text-sm opacity-90">{{ session($type) }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif

@if ($errors->any())
    <div class="fixed top-4 right-4 z-50 max-w-md w-full">
        <div class="mb-2 animate-slide-up">
            <div
                class="flex items-center justify-between p-4 rounded-lg shadow-lg border-l-4 bg-red-50 border-red-500 text-red-800">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                    <div>
                        <p class="font-medium">Validation Error</p>
                        <ul class="text-sm opacity-90 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
