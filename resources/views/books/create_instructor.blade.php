@include('partials.adminnav')
<div class=" mx-auto mt-8 p-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Instructors List Table -->
        <div class="bg-gray-200 rounded-2xl shadow-lg border border-gray-200 p-6 lg:col-span-1 ">
            <div class="border-b pb-4 ">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">
                        📋 Instructors
                    </h2>

                    <a href="{{ url('/admin/dashboard/instructor/list') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        View All →
                    </a>
                </div>

                <p class="text-sm text-gray-500 mt-1">
                    List of all registered instructors.
                </p>
            </div>

            <!-- Search Bar -->
            <form method="GET" class="mb-5">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <label for="instructor_search" class="block text-sm font-medium text-gray-700 mb-1">
                        Instructor
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                            </svg>
                        </span>

                        <input type="text"  id="instructor_search" name="instructor_name" autocomplete="off" placeholder="Type instructor name..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-white border border-gray-300 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition"
                            onkeyup="filterInstructors(this.value)" onfocus="filterInstructors(this.value)">
                    </div>

                    <!-- Suggestions dropdown -->
                    <ul id="instructorSuggestions"
                        class="absolute z-20 mt-1 w-full bg-gray-700 text-white border border-gray-200 rounded-lg shadow-lg h-80 overflow-y-auto hidden">
                        @foreach($instructors as $instructor)
                            <li
                                class="instructor-option px-4 py-2.5 text-sm text-white hover:bg-yellow-200 hover:text-blue-700 cursor-pointer transition"
                                data-name="{{ strtolower($instructor->name) }}"
                                onclick="selectInstructor('{{ addslashes($instructor->name) }}')">
                                {{ $instructor->name }}
                            </li>
                        @endforeach
                        <li id="noInstructorFound" class="px-4 py-2.5 text-sm text-gray-400 hidden">
                            No matching instructor found.
                        </li>
                    </ul>
                </div>
            </form>

            <div class="overflow-x-auto data">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <th class="px-4 py-3 rounded-l-xl">#</th>
                            <th class="px-4 py-3 rounded-r-xl">Name</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($instructors as $instructor)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-gray-800 font-medium">{{ $instructor->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-gray-400">
                                    No instructors found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right side: Add + Assign cards stacked -->
        <div class="grid grid-cols-1 gap-6 lg:col-span-2">

            <!-- Add Instructor Card -->
            <div class="bg-gray-200 rounded-2xl shadow-lg border border-gray-200 p-6 ">
                <div class="border-b pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        👨‍🏫 Add Instructor
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Register a new instructor in the system.
                    </p>
                </div>

                <form action="/admin/dashboard/create_instructor" method="POST">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Instructor Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            placeholder="Enter instructor name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 outline-none transition">
                    </div>

                    <div class="flex justify-end mt-6">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-700 hover:bg-blue-800
                                   text-white rounded-xl shadow-md transition">
                            Add Instructor
                        </button>
                    </div>
                </form>
            </div>

            <!-- Assign Instructor Card -->
            <div class="bg-gray-200 rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="border-b pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        📚 Assign Instructor to Book
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Select an instructor and assign them to a book.
                    </p>
                </div>

                <form action="/admin/dashboard/assign_instructor" method="POST">
                    @csrf

                    <div class="space-y-5">

                        <!-- Instructor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Instructor
                            </label>

                            <select
                                id="instructor_id"
                                name="instructor_id"
                                class="w-full text-sm ">

                                <option value="">Select Instructor</option>

                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Book -->
                        <div>
                            <label class="block text-sm font-medium text-black mb-2">
                                Book
                            </label>

                            <select id="file_id" name="file_id" class="w-full">

                                <option value="">Select Book</option>

                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">
                                        {{ $book->book_number }} - {{ $book->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- Tom Select JS -->
                    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

                    <script>
                        new TomSelect('#instructor_id', {
                            create: false,
                            placeholder: 'Type instructor name...'
                        });

                        new TomSelect('#file_id', {
                            create: false,
                            placeholder: 'Type book number or title...'
                        });
                    </script>

                    <div class="flex justify-end mt-6">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-green-700 hover:bg-green-800
                                   text-white rounded-xl shadow-md transition">
                            Assign Instructor
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@include('partials.notif')
<script>


    function filterInstructors(value) {
        const list = document.getElementById('instructorSuggestions');
        const options = list.querySelectorAll('.instructor-option');
        const noMatch = document.getElementById('noInstructorFound');
        const query = value.trim().toLowerCase();
        let anyVisible = false;
        options.forEach(option => {
            const name = option.getAttribute('data-name');
            if (query === '' || name.includes(query)) {
                option.classList.remove('hidden');
                anyVisible = true;
            } else {
                option.classList.add('hidden');
            }
        });
        noMatch.classList.toggle('hidden', anyVisible);
        list.classList.remove('hidden');
    }
    function selectInstructor(name) {
        document.getElementById('instructor_search').value = name;
        document.getElementById('instructorSuggestions').classList.add('hidden');
    }
    // Hide dropdown when clicking outside
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('instructor_search');
        const list = document.getElementById('instructorSuggestions');
        if (!wrapper.contains(e.target) && !list.contains(e.target)) {
            list.classList.add('hidden');
        }
    });
</script>
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
@extends('partials.footer')
