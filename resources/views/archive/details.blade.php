@include('partials.adminnav')
<section class="max-w-5xl pt-6 px-6 mx-auto rounded-md shadow-md bg-gray-800 sm:mt-4 mt-0">
    <h1 class="text-xl font-bold text-white capitalize ">Research Details</h1>


        @if( auth()->guard('admin')->user()->id == 1 || auth()->guard('admin')->user()->id == 2)
    <form action="{{ route('abstract.update', $file->id) }}" method="POST"  onsubmit="return confirm('Are you sure you want to update the details?')">
        @csrf
        @method('PUT')
        <div class="mt-4">
            <label for="title" class="text-gray-200">Title</label>
            <textarea name="title" id="modal-title" cols="0" rows="2" class="block w-full px-4 py-2 sm:mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white" >{{ $file->title }}</textarea>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="mt-4 md:col-span-2">
                <label class="text-gray-200">Book Number</label>
                <input type="text" name="book_number" id="modal-book_number" value="{{ $file->book_number }}" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600">
            </div>
            <div class="mt-4 md:col-span-2 ">
                <label for="year" class="text-white dark:text-gray-200">Year</label>
                <input type="number" value="{{ $file->year }}" name="year" class="hide-arrows block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white no-spinner">
            </div>
            <div class="mt-4 md:col-span-8">
                <label class="text-gray-200">Department</label>
                <input id="" type="text" name="department" value="{{ $file->department }}"  class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white">
            </div>
        </div>
        <div class="mt-4 ">
            <label class="text-gray-200">Adviser</label>
            <input  type="text" name="adviser" value="{{ $file->adviser }}" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white " >
        </div>
        <div class="mt-4  ">
            <label class="text-gray-200">Members List</label>
            <textarea id="members-preview" name="members" rows="3" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white " >{{ $file->members }}</textarea>
        </div>
        <div class="mt-4">
            <label for="abstract" class="text-gray-200">Abstract/Introduction</label>
            <textarea name="abstract" id="abstract" rows="5" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white" >{{ $file->abstract }}</textarea>
        </div>
        <div class="mt-4 ">
            <label class="text-gray-200">APA Citation</label>
            <textarea rows="2" name="citation" oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white">{{ $file->citation }}</textarea>
        </div>
        <div class="flex justify-end py-4">
            <a href="/admin/dashboard/archive">
                <button
                    type="button"
                    class=" px-16 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-900 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                    Back
                </button>
            </a>
            <button
                type="submit"
                class="ml-10 px-16 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-900 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                Update Details
            </button>

        </div>
    </form>
    @else

    <div class="mt-4">
        <label for="title" class="text-gray-200">Title</label>
        <textarea name="abstract" id="modal-title" cols="0" rows="2" class="block w-full px-4 py-2 sm:mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white" readonly >{{ $file->title }}</textarea>

    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="mt-4 md:col-span-2">
            <label class="text-gray-200">Book Number</label>
            <input type="text" name="book_number" readonly value="{{ $file->book_number }}" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600">
        </div>
        <div class="mt-4 md:col-span-2 ">
            <label for="year" class="text-white dark:text-gray-200">Year</label>
            <input type="number" value="{{ $file->year }}" readonly class="hide-arrows block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white no-spinner">
        </div>
        <div class="mt-4 md:col-span-8">
            <label class="text-gray-200">Department</label>
            <input id="" type="text" name="department" value="{{ $file->department }}" readonly class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white">
        </div>
    </div>
    <div class="mt-4 ">
        <label class="text-gray-200">Adviser</label>
        <input  type="text" value="{{ $file->adviser }}" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white " readonly>
    </div>
    <div class="mt-4  ">
        <label class="text-gray-200">Members List</label>
        <textarea id="members-preview" name="members" rows="3" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white " readonly>{{ $file->members }}</textarea>
    </div>
    <div class="mt-4">
        <label for="abstract" class="text-gray-200">Abstract/Introduction</label>
        <textarea
            rows="5"
            class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600"
            readonly
        >{{ $file->abstract }}</textarea>
    </div>
    <div class="mt-4 ">
        <label class="text-gray-200">APA Citation</label>
        <textarea rows="2" readonly oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white">{{ $file->citation }}</textarea>
    </div>
    <div class="flex justify-center py-4"><a href="/admin/dashboard/archive">
        <button
            type="button"
            class="px-24 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-900 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
            Back
        </button></a>
    </div>
@endif
</section>



</div>

@include('partials.notif')
