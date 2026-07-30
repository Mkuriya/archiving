@include('partials.adminnav')

<div class=" shadow-xl  mt-4 mx-4 margin">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-500 text-white rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-gray-800 p-6 my-4 rounded-xl">
    <!-- Header -->
        <div class="grid grid-cols-1 lg:grid-cols-3 items-center gap-4">
            <!-- Left: Title -->
            <h2 class="text-2xl font-bold text-white whitespace-nowrap justify-self-start">
                👨‍🏫 Instructor Book Assignments
            </h2>

            <!-- Center: Search -->
            <form method="GET" action="" class="w-full flex justify-center">
                <div class="relative w-full sm:w-72 lg:w-80">
                    <!-- Left search icon (decorative) -->
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                        </svg>
                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}" autocomplete="off"
                        placeholder="Search instructor or book number only"
                        class="w-full pl-10 pr-20 py-3 rounded-lg bg-white border border-gray-300 text-gray-800 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">

                    <!-- Right-side buttons: clear (if searching) + submit -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 gap-1">
                        @if(request('search'))
                            <button
                                type="button"
                                onclick="window.location.href='{{ url()->current() }}'"
                                class="flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-md transition"
                                title="Clear search">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif

                        <button
                            type="submit"
                            class="flex items-center justify-center w-8 h-8 text-white bg-blue-700 hover:bg-blue-800 active:bg-blue-900 rounded-md shadow-sm transition"
                            title="Search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right: Add New button -->
            <a href="/admin/dashboard/instructor"
                class="px-5 py-2 bg-blue-900 hover:bg-gray-700 text-white rounded-lg transition text-center whitespace-nowrap justify-self-end">
                + Add New
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">

        @forelse($assignments as $instructorAssignments)

            @php
                $first = $instructorAssignments->first();
                $bookNumbers = $instructorAssignments
                    ->pluck('file.book_number')
                    ->implode(' _ ');
            @endphp

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition duration-300 border relative">

    <!-- Notification Badge -->


    <!-- Book Cover -->
    <div class="h-20 bg-sky-800 flex items-center justify-center p-4">
        <h2 class="text-white text-lg font-bold text-center line-clamp-2">
            {{ $first->instructor->name }}
        </h2>
    </div>

    <!-- Book Details -->
    <div class="p-4">
        <p class="text-sm text-gray-500 mb-2">
            Assigned Books <span class="text-color">({{ $instructorAssignments->count() }})</span>
        </p>
        <div class="bg-gray-100 rounded-lg p-3 h-24 overflow-y-auto">
            <p class="text-sm font-medium">
                {{ $bookNumbers }}
            </p>
        </div>
        <div class="mt-4 text-center">
            <button type="button" class="modal-open px-5 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 transition"
                data-id="{{ $first->instructor->id }}"
                data-instructor="{{ $first->instructor->name }}"
                data-books="{{ $instructorAssignments->pluck('file.book_number')->implode(' _ ') }}">
                View Details
            </button>
        </div>
    </div>
</div>

        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                No instructor assignments found.
            </div>
        @endforelse
    </div>
    <nav aria-label="Page navigation example" class="mt-4 grid justify-items-center">
        @if ($assignments->hasPages())
            <div class="flex">
                <!-- Previous Button -->
                @if ($assignments->onFirstPage())
                    <span class="flex items-center justify-center mr-3 px-3 h-8 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black">Previous</span>
                @else
                    <a href="{{ $assignments->previousPageUrl() }}" class="flex mr-3 items-center justify-center px-3 h-8 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">Previous</a>
                @endif
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    @foreach ($assignments->links()->elements as $element)
                        @if (is_string($element))
                            <li>
                                <span class="flex items-center justify-center px-3 h-8 leading-tight border bg-white border-gray-700 text-black">{{ $element }}</span>
                            </li>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $assignments->currentPage())
                                    <li>
                                        <span class="flex items-center justify-center px-3 h-8 leading-tight border bg-gray-800 border-gray-700 text-white">{{ $page }}</span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" class="flex items-center justify-center px-3 h-8 leading-tight border bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
                <!-- Next Button -->
                @if ($assignments->hasMorePages())
                    <a href="{{ $assignments->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">Next</a>
                @else
                    <span class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black">Next</span>
                @endif
            </div>
        @endif
    </nav>
</div>

 <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-gray-800  text-white w-10/12 md:max-w-4xl mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content bg-white rounded shadow-xl max-w-4xl w-full">
    <!-- Header --> <div class="bg-gray-800 px-6 py-4 border-b">
                         <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-white">
                                Book Information
                            </h2>
                            <button
                                type="button"
                                aria-label="Close"
                                class="modal-close inline-flex items-center justify-center w-8 h-8 rounded-full text-white hover:text-white hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                 <div class="p-6 bg-gray-50 text-black">
                    <form id="updateForm" action="/admin/dashboard/archive/pending/status/" method="POST">
                        @csrf
                        @method('PUT')
                        <label>Instructor</label>
                        <input
                            id="modal-instructor"
                            type="text"
                            class="block w-full px-4 py-2 mt-2 border border-black rounded-md text-black"
                            readonly>

                        <label class="mt-4 block">Book Numbers</label>
                        <textarea
                            id="modal-books"
                            rows="4"
                            class="block w-full px-4 py-2 mt-2 border border-black rounded-md"
                            readonly></textarea><br>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const modal = document.querySelector('.modal');
        const openModalButtons = document.querySelectorAll('.modal-open');
        const closeModalButtons = document.querySelectorAll('.modal-close');

        openModalButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                const instructor = this.getAttribute('data-instructor');
                const books = this.getAttribute('data-books');

                console.log(instructor);
                console.log(books);

                document.getElementById('modal-instructor').value = instructor;
                document.getElementById('modal-books').value = books;

                modal.classList.remove('opacity-0');
                modal.classList.remove('pointer-events-none');

            });

        });

        closeModalButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                modal.classList.add('opacity-0');
                modal.classList.add('pointer-events-none');

            });

        });

        modal.querySelector('.modal-overlay')
            .addEventListener('click', function () {

                modal.classList.add('opacity-0');
                modal.classList.add('pointer-events-none');

            });

    });
</script>
@include('partials.footer')
