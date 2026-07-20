@include('partials.adminnav')
<div class="max-w-6xl mx-auto mt-8 p-6">
    <div class="grid grid-cols-1 gap-6">

        <!-- Add Instructor Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 ">
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
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <div class="border-b pb-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    📚 Assign Instructor to Book
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Select an instructor and assign them to a book.
                </p>
            </div>

            <form action="" method="POST">
                @csrf

                <div class="space-y-5">

                    <!-- Instructor -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Instructor
                        </label>

                        <select
                            name="instructor_id"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 outline-none">

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
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Book
                        </label>

                        <select
                            name="file_id"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 outline-none">

                            <option value="">Select Book</option>

                            @foreach($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->book_number }}
                                    - {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

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
@extends('partials.footer')
