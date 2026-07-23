@include('partials.adminnav')

<div class="bg-white rounded-xl shadow-xl p-6 mt-4 mx-4">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-500 text-white rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">
            👨‍🏫 Instructor Book Assignments
        </h2>

        <a href="/admin/dashboard/instructor"
           class="px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition">
            + Add New
        </a>
    </div>

    <!-- Search -->
    <div class="mb-5">
    <form method="GET" action="">
       <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                    </svg>
                </span>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search instructor only"
                    class="w-full pl-10 pr-4 py-3 rounded-lg bg-white border border-gray-300 text-gray-800 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">

                @if(request('search'))
                    <button
                        type="button"
                        onclick="window.location.href='{{ url()->current() }}'"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition"
                        title="Clear search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif
            </div>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-700 text-white font-medium rounded-lg shadow-sm hover:bg-blue-800 active:bg-blue-900 transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                </svg>
                Search
            </button>

        </div>
    </form>
</div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">

        @forelse($assignments as $instructorAssignments)

            @php
                $first = $instructorAssignments->first();
                $bookNumbers = $instructorAssignments
                    ->pluck('file.book_number')
                    ->implode(', ');
            @endphp

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition duration-300 border">

                <!-- Book Cover -->
                <div class="h-20  bg-sky-800 flex items-center justify-center p-4">
                    <h2 class="text-white text-lg font-bold text-center line-clamp-2">
                        {{ $first->instructor->name }}
                    </h2>
                </div>

                <!-- Book Details -->
                <div class="p-4">

                    <p class="text-sm text-gray-500 mb-2">
                        Assigned Books
                    </p>

                    <div class="bg-gray-100 rounded-lg p-3 h-24 overflow-y-auto">
                        <p class="text-sm font-medium">
                            {{ $bookNumbers }}
                        </p>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="button"  class="modal-open px-5 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 transition"
                            data-id="{{ $first->instructor->id }}"
                            data-instructor="{{ $first->instructor->name }}"
                            data-books="{{ $instructorAssignments->pluck('file.book_number')->implode(', ') }}">
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
    <div class="mt-6 flex justify-center">
        {{ $assignments->appends(request()->query())->links('pagination::tailwind') }}
    </div>
</div>

 <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-gray-800  text-white w-10/12 md:max-w-4xl mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content bg-white rounded shadow-xl max-w-4xl w-full">
    <!-- Header --> <div class="bg-gray-800 px-6 py-4 border-b">
                        <h2 class="text-xl font-semibold text-white">
                            Book Information
                        </h2>
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

                        <div class=" px-6 py-4 border-t flex justify-end gap-2">
                            <button type="button" class="modal-close px-5 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><script>
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
