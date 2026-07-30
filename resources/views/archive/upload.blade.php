@include('partials.adminnav')@if ($errors->any())
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

<section class="max-w-5xl pt-6 px-6 mx-auto rounded-xl shadow-md bg-gray-800 sm:mt-4 mt-0 border border-gray-200">
<h1 class="text-xl font-bold text-white capitalize ">Upload Research</h1>
<form id="citation-form" name="citation-form" action="/admin/dashboard/upload/file" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="status" value="0">
    <div class="mt-4">
        <label for="title" class="text-gray-200">Title</label>
        <input type="text" oninput="filterInput(this)" onchange="upperCase()" name="title" id="title" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
        <div class="mt-4 sm:col-span-3">
            <label for="year" class="text-white dark:text-gray-200">Year</label>
            <input min="1900" max="2099" step="1" name="year" id="year" type="number" class="hide-arrows block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white no-spinner">
        </div>
        <div class="mt-4 sm:col-span-3">
            <label class="text-gray-200">Book Number</label>
            <input type="text" name="book_number" value="{{$bookNumber}}" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600">
        </div>
        <div class="mt-4 sm:col-span-6">
            <label class="text-gray-200">Department</label>

            <!-- Dropdown -->
            <select id="departmentSelect"
                    class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600"
                    onchange="toggleDepartmentInput()">
                <option value="">Select Department</option>
                <option value="BSAMT">BSAMT</option>
                <option value="BSAET">BSAET</option>
                <option value="MEAM">MEAM</option>
                <option value="Others">Others</option>
            </select>

            <!-- Hidden input -->
            <input
                type="text"
                id="departmentInput"
                name="department"
                placeholder="Enter Department"
                class="hidden block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600">
        </div>
    </div>
    <br>
    <div class="mt-4 flex justify-between items-center">
        <label for="" class="text-gray-200">Members</label>
        <button type="button" onclick="addAuthor()" class="p-2 bg-blue-900 hover:bg-gray-700 text-white rounded-md">Add Author</button>
    </div>

    <div id="authors-container" class="mt-2">
        <!-- Author fields will be added here -->

    </div>

    <div class="mt-4 hidden">
        <label class="text-gray-200">Members List</label>
        <textarea id="members-preview" name="members" rows="3" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white " readonly></textarea>
    </div>
    <div class="mt-4">
        <label class="text-gray-200">Adviser</label>
        <input type="text" onchange="upperCasee()" name="adviser" id="adviser" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600">
    </div>

    <div class="mt-4">
        <label for="abstract" class="text-gray-200">Abstract/Introduction</label>
        <textarea name="abstract" id="abstract" oninput="filterInput(this)" cols="0" rows="5" class="block w-full px-4 py-2 sm:mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white "></textarea>
    </div>
    <div class="mt-4 ">
        <label class="text-gray-200">APA Citation</label>
        <input id="citation-preview" type="text" name="citation" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white " readonly>
    </div>
    <div class="flex justify-center py-4">
        <button type="submit" class="px-16 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-900 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Save</button>
        <a href="/admin/dashboard">
            <button type="button" class="ml-10 px-16 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-900 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Back</button>
        </a>
    </div>
</form>
</section>



<script>
function toggleDepartmentInput() {
    const select = document.getElementById('departmentSelect');
    const input = document.getElementById('departmentInput');

    if (select.value === 'Others') {
        input.classList.remove('hidden');
        input.value = '';
        input.focus();
    } else {
        input.classList.add('hidden');
        input.value = select.value;
    }
}

</script>




@include('partials.notif')

<script src="/js/uploads.js"></script>
<script src="/js/modal.js"></script>
@extends('partials.footer')
