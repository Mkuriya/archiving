@include('partials.adminnav')
    @if ($errors->any())
        <!-- Modal overlay -->
        <div id="errorModalOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
            <!-- Modal structure -->
            <div class="bg-gray-300 rounded-lg shadow-lg w-11/12 md:w-1/3">
                <div class="flex justify-between items-center bg-red-500 text-white text-lg p-4 rounded-t-lg">
                    <!-- Error icon -->
                    <svg height="32" style="overflow:visible;enable-background:new 0 0 32 32" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="16" style="fill:#D72828;"/>
                        <path d="M14.5,25h3v-3h-3V25z M14.5,6v13h3V6H14.5z" style="fill:#E6E6E6;"/>
                    </svg>
                    <h5 class="font-bold">SOME FIELDS ARE MISSING, PLEASE FILL THEM.</h5>
                    <button id="closeErrorModal" class="text-2xl leading-none">&times;</button>
                </div>
                <div class="p-4">
                    <div class="text-red-800 text-start pl-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
<section class="max-w-5xl pt-6 px-6 mx-auto rounded-md shadow-md sm:mt-4 mt-0 text-white">


    <form id="borrow-form" action="/admin/dashboard/logbook/input" method="POST">
        @csrf
        <div class="max-w-4xl mx-auto bg-gray-800 rounded-xl shadow-xl p-8">
           <div class="flex items-center justify-between mb-6 border-b border-gray-700 pb-3">
                <h1 class="text-2xl font-bold text-white">
                    📚 Research Log Book
                </h1>
            </div>
            <input hidden type="text" name="status" class="border border-gray-600" value="0">

            <!-- Borrow Information -->
            <div class="grid md:grid-cols-2 gap-6 mt-4">
                <!-- Borrow Date -->
                <div>
                    <label class="block text-sm text-white font-medium mb-2">
                        Date
                    </label>
                   <input type="datetime-local" name="date" value="{{ old('b_date', now()->format('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white focus:outline-none">
                </div>

                <!-- Book Number -->
                <div>
                    <label class="block text-sm text-white font-medium mb-2">
                        Book Number
                    </label>

                    <input type="number" id="book_number" name="b_no" placeholder="Enter Book Number" class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white focus:outline-none">
                </div>
            </div>

            <!-- Book Title -->
            <div class="mt-6">
                <label class="block text-sm text-white font-medium mb-2">
                    Research Title
                </label>
                <textarea id="title" name="b_name" rows="3" readonly placeholder="Book title will appear here..." class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white resize-none focus:outline-none"></textarea>
            </div>

            <!-- Student Information -->
            <div class="mt-6">
                <label class="block text-sm text-white font-medium mb-2">
                    Student Name
                </label>
                <input type="text" name="s_name" placeholder="Enter Student Name" class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white focus:outline-none">
            </div>
            <!-- Buttons -->
            <div class="flex justify-end gap-4 mt-6">

                <a href="/admin/dashboard" class="px-4 py-3 bg-danger hover:bg-gray-700 text-white rounded-lg transition">
                    Cancel
                </a>

                <button type="submit" class="px-4 py-3 bg-blue-900 hover:bg-gray-700 text-white rounded-lg transition shadow-lg">
                    Save
                </button>
            </div>
        </div>
    </form>
</section>
@include('partials.notif')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const bookInput = document.getElementById('book_number');
    const titleInput = document.getElementById('title');

    bookInput.addEventListener('keyup', function () {

        let bookNumber = this.value;

        if (bookNumber === '') {
            titleInput.value = '';
            return;
        }

        fetch('/get-book/' + bookNumber)
            .then(response => response.json())
            .then(data => {

                if (data.title) {
                    titleInput.value = data.title;
                } else {
                    titleInput.value = '';
                }

            })
            .catch(error => {
                console.log(error);
                titleInput.value = '';
            });

    });

});
</script>
<script src="/js/modal.js"></script>
@extends('partials.footer')
