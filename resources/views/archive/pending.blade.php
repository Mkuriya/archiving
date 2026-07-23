@include('partials.adminnav')
<div class="content px-10">
    <div class="mt-6 mb-4 md:flex md:items-center md:justify-between">
        <div class="inline-flex overflow-hidden border divide-x rounded-lg bg-white rtl:flex-row-reverse border-gray-700 divide-gray-700">
            <ul class="flex">
                <li class="mr-3">
                    <a class="inline-block rounded py-1.5 px-3  text-black bg-white " href="/admin/dashboard/archive">Archive List</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block rounded py-1.5 px-3  text-white border-b border-b-4 border-white bg-gray-900" href="/admin/dashboard/archive/pending">Pending List</a>
                </li>
                <li class="">
                    <a class="inline-block rounded py-1.5 px-3  text-black bg-white " href="/admin/dashboard/archive/decline">Decline List</a>
                </li>
            </ul>
        </div>
         <div class="text-white w-full h-12 sm:w-2/6 ">
            <form action="{{ url('/admin/dashboard/archive/pending') }}" id="searchForm" method="get" class=" w-full mx-auto h-full">
                <div class="flex flex-row mt-2 sm:mt-0 md:flex-row items-center h-full">
                    <div class="relative h-full  ">
                       <div class="relative w-full h-full md:w-36 "  x-data="{ open: false, selected: '{{ request('department') ?: 'Department' }}' }">
                            <button type="button"  @click="open = !open" class="text-black hover:text-white w-full bg-white  hover:bg-gray-800 font-medium text-sm px-2 py-2 h-full  flex justify-between items-center">
                                <span x-text="selected"></span>
                                <span>▼</span>
                            </button>
                            <div x-show="open" @click.away="open=false" class="absolute z-50 w-full mt-1 bg-white shadow-lg dropdown-list " >
                                <div class="px-3 py-2 h-full text-black hover:bg-gray-800 hover:text-white cursor-pointer"  @click="selected='Department'; open=false; $refs.department.value=''" >
                                    Department
                                </div>
                                @foreach($departments as $department)
                                    <div class="px-3 py-2 text-black hover:bg-gray-800 hover:text-white cursor-pointer" @click="selected='{{ $department->department }}'; open=false; $refs.department.value='{{ $department->department }}'" >
                                        {{ $department->department }}
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="department" x-ref="department" value="{{ request('department') }}" >
                        </div>
                    </div>
                    <input type="search" autocomplete="off" id="default-search" value="{{ request()->input('search') }}" name="search" class="w-full p-4 text-sm text-black hover:text-white   bg-white hover:bg-gray-800 focus:outline-none md:py-0 h-full md:border-b-2 md:border-t-2 border-y-2 " placeholder="Search Title, Year or Book Number" />
                    <button type="submit" class="text-black hover:text-white  bg-white hover:bg-gray-800 font-medium text-sm px-4 py-4 md:py-0 h-full rounded-lg-g md:rounded-r-lg">Search</button>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <br>
    <div class="flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 ">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                 <div class="overflow-hidden border border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left text-center text-white">
                                    Book Number
                                </th>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-white">
                                    <div class="flex items-center gap-x-3">
                                        <button class="flex items-center gap-x-2">
                                            <span>Title</span>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-white">
                                    Year
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-white">
                                    Department
                                </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-white">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-white">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700 bg-white text-black">
                            @forelse ($files as $item)
                                @if ($item->status == 0)
                                    <tr class="hover:bg-gray-800 hover:text-white">
                                         <td class="px-4 py-4 text-sm whitespace-nowrap text-center">
                                            <h2 class="text-sm font-normal">{{$item->book_number}}</h2>
                                        </td>
                                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ \Illuminate\Support\Str::words($item->title, 10, '...') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            {{$item->year}}
                                        </td>

                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="flex items-center gap-x-2">
                                                {{ $item->department }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="flex items-center gap-x-2">
                                                @if($item->status == 0)
                                                    <h1 class="">Pending</h1>
                                                @elseif($item->status == 1)
                                                    <h1 class="">Approve</h1>
                                                @else
                                                    <h1 class="">Decline</h1>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-1 py-4 text-sm whitespace-nowrap">
                                            <button class="modal-open hover:border-red-600  font-bold py-2 px-4 rounded-full"
                                                data-title="{{ $item->title }}"
                                                data-year="{{ $item->year }}"
                                                data-department="{{ $item->department }}"
                                                data-status="{{ $item->status }}"
                                                data-adviser="{{ $item->adviser }}"
                                                data-book_number="{{ $item->book_number }}"
                                                data-members="{{ $item->members }}"
                                                data-citation="{{ $item->citation }}"
                                                data-abstract="{{ $item->abstract }}"
                                                data-id="{{ $item->id }}">
                                                <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                </svg>
                                            </button>

                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-sm text-center text-gray-300">
                                        No data available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                 </div>
                 <nav aria-label="Page navigation example"  class="mt-4 grid justify-items-center">
                    @if ($files->hasPages())
                         <div class="flex">
                            <!-- Previous Button -->
                            @if ($files->onFirstPage())
                                <span class="flex items-center justify-center mr-3 px-3 h-8 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black">Previous</span>
                            @else
                                <a href="{{ $files->previousPageUrl() }}" class="flex mr-3 items-center justify-center px-3 h-8 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">Previous</a>
                            @endif

                            <ul class="flex items-center -space-x-px h-8 text-sm">
                                @foreach ($files->links()->elements as $element)
                                    @if (is_string($element))
                                        <li>
                                            <span class="flex items-center justify-center px-3 h-8 leading-tight border bg-white border-gray-700 text-black">{{ $element }}</span>
                                        </li>
                                    @endif
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $files->currentPage())
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
                            @if ($files->hasMorePages())
                                <a href="{{ $files->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black hover:bg-gray-700 hover:text-white">Next</a>
                            @else
                                <span class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg bg-white border-gray-700 text-black">Next</span>
                            @endif
                        </div>
                    @endif
                </nav>
             </div>
         </div>
    <!-- Modal HTML -->
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
                        <div class="grid grid-cols-3 gap-6  sm:grid-cols-12">
                            <div class="col-span-12 sm:col-span-12">
                                <label class=" pl-2" for="title">Title</label>
        {{-- readonly --}}      <textarea name="title" id="modal-title" cols="0" rows="2" class="block w-full px-4 py-2 sm:mt-2  border border-black  rounded-md  focus:border-white" onchange="upperCase()" ></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-12">
                            <div class="col-span-12 sm:col-span-4">
                                <label class="pl-2" for="lastname">Year</label>
                            {{-- disabled --}}    <input id="modal-year" name="year"  type="text" class="block w-full px-4 py-2 mt-2 border border-black rounded-md  focus:border-blue-500 focus:outline-none focus:ring">
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <label class="pl-2" for="lastname">Book Number</label>
                            {{-- disabled --}}    <input id="modal-book_number" name="book_number"  type="text" class="block w-full px-4 py-2 mt-2 border border-black rounded-md  focus:border-blue-500 focus:outline-none focus:ring">
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <label class="pl-2" for="title">Department</label>
                            {{-- disabled --}}    <input id="modal-department" name="department"  type="text" class="block w-full px-4 py-2 mt-2 border border-black rounded-md  focus:border-blue-500 focus:outline-none focus:ring">
                            </div>
                        </div><br>
                        <div class="col-span-12 sm:col-span-4 ">
                            <label class="pl-2" for="title">Citation</label>
        {{-- disabled --}}     <input id="modal-citation" name="citation"  type="text" class="block w-full px-4 py-2 mt-2 border border-black rounded-md  focus:border-blue-500 focus:outline-none focus:ring">
                        </div>
                        <div class="grid grid-cols-2 gap-6  sm:grid-cols-12 mt-4">
                            <div class="col-span-12 sm:col-span-6">
                                <label class="pl-2" for="lastname">Adviser</label>
                                <input id="modal-adviser" onchange="upperCase()" name="adviser" type="text" class="block w-full px-4 py-2 mt-2 border border-black rounded-md  focus:border-blue-500 focus:outline-none focus:ring">
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label class=" pl-2 font-semibold flex items-center gap-2" for="firstname">
                                    Status
                                    <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded-full">Editable</span>
                                </label>
                                    <select id="modal-status" name="status" class="block w-full px-3 py-2 mt-2 border-2 rounded-md  border-blue-500 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="0" >Pending</option>
                                        <option value="1" >Approve</option>
                                        <option value="2" >Decline</option>
                                    </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-12">
                            <div class="col-span-12 sm:col-span-12">
                                <label for="members" class="">Members</label>
                                <textarea name="members" id="modal-members" cols="0" rows="2" class="block w-full px-4 py-2 sm:mt-2  border border-black rounded-md  focus:border-white"  ></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-12">
                            <div class="col-span-12 sm:col-span-12">
                                <label for="abstract" class="">Abstract/Introduction</label>
    {{-- -readonly --}}         <textarea name="abstract" id="modal-abstract" cols="0" rows="5" class="block w-full px-4 py-2 sm:mt-2  border border-black rounded-md  focus:border-white"  ></textarea>
                            </div>
                        </div>
                        <div class=" px-6 py-4 border-t flex justify-end gap-2">
                            <button type="button" class="modal-close px-5 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Close</button>
                            <button type="submit" class="px-5 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Script -->
<script>
function upperCase() {
    const title = document.getElementById("modal-title");
    const adviser = document.getElementById("modal-adviser");

    if (title) {
        title.value = title.value.toUpperCase();
    }

    if (adviser) {
        adviser.value = adviser.value.toUpperCase();
    }
}
    document.addEventListener('DOMContentLoaded', function () {
        // Get the modal
        var modal = document.querySelector('.modal');

        // Get all buttons that open the modal
        var openModalButtons = document.querySelectorAll('.modal-open');

        // Get close button
        var closeModalButtons = document.querySelectorAll('.modal-close');

        openModalButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Get the data attributes from the clicked button
                var title = button.getAttribute('data-title');
                var year = button.getAttribute('data-year');
                var department = button.getAttribute('data-department');
                var status = button.getAttribute('data-status');
                var adviser = button.getAttribute('data-adviser');
                var book_number = button.getAttribute('data-book_number');
                var members = button.getAttribute('data-members');
                var citation = button.getAttribute('data-citation');
                var abstract = button.getAttribute('data-abstract');
                var id = button.getAttribute('data-id');

                // Populate the modal with the data
                document.getElementById('modal-title').value = title;
                document.getElementById('modal-year').value = year;
                document.getElementById('modal-department').value = department;
                document.getElementById('modal-status').value = status;
                document.getElementById('modal-adviser').value = adviser;
                document.getElementById('modal-book_number').value = book_number;
                document.getElementById('modal-members').value = members;
                document.getElementById('modal-citation').value = citation;
                document.getElementById('modal-abstract').value = abstract;

                // Update form action to point to the correct URL for the selected item
                var form = document.getElementById('updateForm');
                form.action = '/admin/dashboard/archive/pending/status/' + id;

                // Show the modal
                modal.classList.remove('opacity-0');
                modal.classList.remove('pointer-events-none');
            });
        });

        closeModalButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Hide the modal
                modal.classList.add('opacity-0');
                modal.classList.add('pointer-events-none');
            });
        });

        // Close the modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.classList.add('opacity-0');
                modal.classList.add('pointer-events-none');
            }
        };
    });
</script>
@include('partials.footer')
