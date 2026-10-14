@include('partials.adminnav')
<style>
    /* Yes / Completed */
.bg-green-900 {
    background-color: #14532d;
}

.text-green-300 {
    color: #86efac;
}

/* No / Not Started */
.bg-red-900 {
    background-color: #7f1d1d;
}

.text-red-300 {
    color: #fca5a5;
}

/* In Progress */
.bg-yellow-900 {
    background-color: #713f12;
}

.text-yellow-300 {
    color: #fde047;
}
</style>
<div class="bg-white rounded-xl shadow-xl mt-4 mx-4 text-white ">
    <div class="bg-gray-800 p-6  rounded-xl">
    <!-- Header -->
        <div class="grid grid-cols-1 lg:grid-cols-3 items-center gap-4">
            <!-- Left: Title -->
            <h2 class="text-2xl font-bold text-white whitespace-nowrap justify-self-starte">
                📚 Thesis Scan & Edit Log
            </h2>

            <!-- Center: Search -->
            <form method="GET" action="{{ url()->current() }}" class="w-full flex justify-center">
                <div class="relative w-full sm:w-72 lg:w-80">
                    <!-- Left search icon (decorative) -->
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                        </svg>
                    </span>

                    <input type="text" id="borrowSearch" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Search book number..." class="w-full pl-10 pr-20 py-3 rounded-lg bg-white border border-gray-300 text-gray-800 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">

                    <!-- Right-side buttons: clear (if searching) + submit -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 gap-1">
                        @if(request('search'))
                            <button type="button" onclick="window.location.href='{{ url()->current() }}'" class="flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-md transition" title="Clear search">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif

                        <button type="submit" class="flex items-center justify-center w-8 h-8 text-white bg-blue-700 hover:bg-blue-800 active:bg-blue-900 rounded-md shadow-sm transition" title="Search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right: Chart -->
            <div class="justify-self-end mr-3">
                <div class="w-16 h-16 relative">
                    <canvas id="bookProgressChart"></canvas>

                    <!-- Center text -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-xs font-bold text-white">
                            {{ $totalDone }}
                        </span>
                    </div>
                </div>

                <div class="text-center mt-2 text-sm text-gray-300">
                    @if(request('search'))
                        Search Results: {{ $files->total() }}
                    @else
                        Total Book: {{ $files->total() }}
                    @endif
                </div>
            </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-700">
        <table class="w-full text-sm text-left text-white">

            <thead class="bg-gray-900 text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-center">Book No.</th>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Scanned</th>
                    <th class="px-6 py-4">Edited</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>

            <tbody id="scanTable">
                @forelse ($files as $item)
                    @php
                        $scanned = optional($item->scan)->is_scanned ?? false;
                        $edited = optional($item->scan)->is_edited ?? false;
                        $status = ($scanned && $edited) ? 'Completed': ((!$scanned && !$edited)? 'Not Started': 'In Progress');
                    @endphp

                    <tr class="border-t border-gray-700 hover:bg-gray-700/40 transition">
                        <!-- Book Number -->
                        <td class="px-6 py-4 font-semibold text-center">
                            {{ $item->book_number }}
                        </td>
                        <td class="px-6 py-4 font-semibold">
                            <div class="inline-flex items-center gap-x-3">
                                <span>{{ \Illuminate\Support\Str::words($item->title, 12, '...') }}</span>
                            </div>
                        </td>

                        <!-- Scanned -->
                        <td class="px-6 py-4">
                            @if($scanned)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-900 text-green-300">
                                    ✓ Yes
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-900 text-red-300">
                                    ✕ No
                                </span>
                            @endif
                        </td>

                        <!-- Edited -->
                        <td class="px-6 py-4">
                            @if($edited)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-900 text-green-300">
                                    ✓ Yes
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-900 text-red-300">
                                    ✕ No
                                </span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($scanned && $edited)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-900 text-green-300">
                                    ✓ Completed
                                </span>
                            @elseif(!$scanned && !$edited)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-900 text-red-300">
                                    Not Started
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-900 text-yellow-300">
                                    ⏳ In Progress
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="inline-flex items-center ">

                                @if($scanned && $edited)

                                    <!-- Completed -->
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-green-900/40 border border-green-700 text-green-300 text-xs font-semibold">
                                        Complete
                                    </span>
                                @else

                                    <!-- Toggle Scan -->
                                    @if(!$scanned)
                                        <form action="{{ route('books.toggleScan', $item->id) }}"
                                            method="POST"
                                            class="inline" onsubmit="return confirm('Mark this book {{ $item->book_number }} as scan?');">
                                            @csrf
                                            <button type="submit" title="Mark as scanned" class="inline-flex items-center justify-center w-9 h-9 rounded-lg transition bg-gray-700/50 border border-gray-600 text-gray-300 hover:bg-blue-600 hover:border-blue-500 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M4 7V5a2 2 0 0 1 2-2h2"/> <path d="M20 7V5a2 2 0 0 0-2-2h-2"/>  <path d="M4 17v2a2 2 0 0 0 2 2h2"/>  <path d="M20 17v2a2 2 0 0 1-2 2h-2"/><line x1="7" y1="12" x2="17" y2="12"/>
                                                </svg>

                                            </button>
                                        </form>


                                    <!-- Toggle Edit -->
                                    @elseif($scanned && !$edited)
                                        <form action="{{ route('books.toggleEdit', $item->id) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Mark this book {{ $item->book_number }} as edited?');">
                                            @csrf
                                            <button type="submit" title="Mark as edited" class="inline-flex items-center justify-center w-9 h-9 rounded-lg transition bg-gray-700/50 border border-gray-600 text-gray-300 hover:bg-purple-600 hover:border-purple-500 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                    <path d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                @endif

                            </div>
                            {{--@if (empty(trim($item->adviser ?? '')))
                                    <span class="ml-2 text-red-600 text-xs font-semibold">
                                        ⚠ Missing Hardcopy
                                    </span>
                                @endif --}}

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-400">
                            @if(request('search'))
                                No matching records found for
                                "<span class="text-white font-semibold">{{ request('search') }}</span>".
                            @else
                                No data available.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="">
        <nav aria-label="Page navigation" class="mt-4 grid justify-items-center">
            @if ($files->hasPages())
                <div class="flex">
                    <!-- Previous Button -->
                    @if ($files->onFirstPage())
                        <span class="flex items-center justify-center mr-3 px-3 h-8 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black">
                            Previous
                        </span>
                    @else
                        <a href="{{ $files->previousPageUrl() }}" class="flex mr-3 items-center justify-center px-3 h-8 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">
                            Previous
                        </a>
                    @endif
                    <!-- Page Numbers -->
                    <ul class="flex items-center -space-x-px h-8 text-sm">
                        @foreach ($files->links()->elements as $element)
                            @if (is_string($element))
                                <li>
                                    <span class="flex items-center justify-center px-3 h-8 leading-tight border bg-white border-gray-700 text-black">
                                        {{ $element }}
                                    </span>
                                </li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $files->currentPage())
                                        <li>
                                            <span class="flex items-center justify-center px-3 h-8 leading-tight border bg-gray-800 border-gray-700 text-white">
                                                {{ $page }}
                                            </span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $url }}" class="flex items-center justify-center px-3 h-8 leading-tight border bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                    <!-- Next Button -->
                    @if ($files->hasMorePages())
                        <a href="{{ $files->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">
                            Next
                        </a>
                    @else
                        <span class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black">
                            Next
                        </span>
                    @endif
                </div>
            @endif
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const totalBooks = {{ $files->total() }};
    const totalDone = {{ $totalDone }};
    const remaining = Math.max(totalBooks - totalDone, 0);

    new Chart(document.getElementById('bookProgressChart'), {
        type: 'doughnut',
        data: {
            labels: ['Done', 'Remaining'],
            datasets: [{
                data: [totalDone, remaining],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '50%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw;
                        }
                    }
                }
            }
        }
    });
</script>
@include('partials.notif')
@include('partials.footer')
