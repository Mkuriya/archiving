@include('partials.adminnav')

<div class="content px-10">
    <div class="mt-6 mb-4 md:flex md:items-center md:justify-between">
        <div class="inline-flex overflow-hidden border divide-x rounded-lg bg-white rtl:flex-row-reverse border-gray-700 divide-gray-700">
            <ul class="flex">
                <li class="mr-3">
                    <a class="inline-block rounded py-1.5 px-3  text-black " href="/admin/dashboard/archive">Archive List</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block rounded py-1.5 px-3  text-black " href="/admin/dashboard/archive/pending">Pending List</a>
                </li>
                <li class="">
                    <a class="inline-block rounded py-1.5 px-3  text-white border-b border-b-4 border-white bg-gray-900" href="/admin/dashboard/archive/decline">Decline List</a>
                </li>
            </ul>
        </div>
        <div class="text-white w-full h-12 sm:w-2/6 ">
            <form action="{{ url('/admin/dashboard/archive/decline') }}" id="searchForm" method="get" class=" w-full mx-auto h-full">
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
                    <input type="search" id="default-search" value="{{ request()->input('search') }}" name="search" class="w-full p-4 text-sm text-black hover:text-white  bg-white hover:bg-gray-800 focus:outline-none md:py-0 h-full md:border-b-2 md:border-t-2 border-y-2  " placeholder="Search Title, Year or Book Number" />
                    <button type="submit" class="text-black hover:text-white  bg-white hover:bg-gray-800 hover:text-white font-medium text-sm px-4 py-4 md:py-0 h-full rounded-lg-g md:rounded-r-lg">Search</button>
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
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-center ">Book Number </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">Title </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">Year </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">Department </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">Status </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">Action </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700 bg-white text-black">
                            @forelse ($files as $item)
                                @if ($item->status == 2)
                                    <tr class="hover:bg-gray-800 hover:text-white">
                                        <td class="px-4 py-4 text-sm whitespace-nowrap text-center">
                                            <h2 class="text-sm font-normal">{{$item->book_number}}</h2>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <span>{{ \Illuminate\Support\Str::words($item->title, 10, '...') }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            {{$item->year}}
                                        </td>

                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                           <h2 class="text-sm font-normal">{{$item->department}}</h2>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="flex items-center gap-x-2">
                                                @if($item->status == 0)
                                                    <h1>Pending</h1>
                                                @elseif($item->status == 1)
                                                    <h1>Approve</h1>
                                                @else
                                                    <h1>Decline</h1>
                                                @endif

                                            </div>
                                        </td>
                                        <td class="px-1 py-4 text-sm whitespace-nowrap">
                                            <div class="flex items-center gap-x-2">
                                                <button class="modal-open hover:border-red-600 hover:text-red-600 font-bold py-2 px-4 rounded-full">
                                                    <i class="fas fa-pen-to-square"></i>
                                                </button>

                                                <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="text-red-400 hover:text-red-600 font-bold py-2 px-4 rounded-full">
                                                         <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
                                                <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
                                                <div class="modal-container bg-gray-900 text-white w-10/12 md:max-w-4xl mx-auto rounded shadow-lg z-50 overflow-y-auto">
                                                    <div class="modal-content bg-white rounded shadow-xl max-w-4xl w-full">
      <!-- Header -->                                   <div class="bg-gray-800 px-6 py-4 border-b">
                                                            <h2 class="text-xl font-semibold text-white">
                                                                Book Information
                                                            </h2>
                                                        </div>
                                                        <form action="/admin/dashboard/archive/decline/status/{{$item->id}}" method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="p-6 bg-gray-50 text-black">

                                                                <div class="space-y-4">

                                                                    <!-- Title -->
                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-black mb-1">
                                                                            Title
                                                                        </label>
                                                                        <input name="title" value="{{$item->title}}" disabled type="text" class="w-full border border-black rounded px-3 py-2 bg-white">
                                                                    </div>

                                                                    <!-- Department -->
                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-black mb-1">
                                                                            Department
                                                                        </label>
                                                                        <input name="department" value="{{$item->department}}" disabled type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-white">
                                                                    </div>

                                                                    <div class="grid md:grid-cols-2 gap-4">

                                                                        <!-- Book Number -->
                                                                        <div>
                                                                            <label class="block text-sm font-semibold text-black mb-1">
                                                                                Book Number
                                                                            </label>
                                                                            <input name="book_number" value="{{$item->book_number}}" disabled type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-white">
                                                                        </div>

                                                                        <!-- Year -->
                                                                        <div>
                                                                            <label class="block text-sm font-semibold text-black mb-1">
                                                                                Year
                                                                            </label>
                                                                            <input name="year" value="{{$item->year}}" disabled type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-white">
                                                                        </div>

                                                                    </div>

                                                                    <!-- Status -->
                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-black mb-1">
                                                                            Status
                                                                        </label>

                                                                        <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 bg-white">

                                                                            <option value="0"
                                                                                {{$item->status == '0' ? 'selected' : ''}}>
                                                                                Pending
                                                                            </option>

                                                                            <option value="1"
                                                                                {{$item->status == '1' ? 'selected' : ''}}>
                                                                                Approved
                                                                            </option>

                                                                            <option value="2"
                                                                                {{$item->status == '2' ? 'selected' : ''}}>
                                                                                Declined
                                                                            </option>

                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <!-- Footer -->
                                                            <div class="px-6 py-4 border-t flex justify-end gap-2">

                                                                <button
                                                                    type="button"
                                                                    class="modal-close px-5 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                                                    Close
                                                                </button>

                                                                <button
                                                                    type="submit"
                                                                    class="px-5 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">
                                                                    Update
                                                                </button>

                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-sm font-medium text-gray-200 whitespace-nowrap text-center">
                                        No data available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                 </div>
                 <nav aria-label="Page navigation example" class="mt-4 grid justify-items-center">
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
     </div>
     <script>
document.addEventListener('DOMContentLoaded', () => {

    // OPEN MODAL
    const openButtons = document.querySelectorAll('.modal-open');

    openButtons.forEach(button => {
        button.addEventListener('click', function () {

            // Get the modal in the same row
            const row = this.closest('tr');
            const modal = row.querySelector('.modal');

            modal.classList.remove('opacity-0');
            modal.classList.remove('pointer-events-none');
        });
    });

    // CLOSE MODAL BUTTON
    const closeButtons = document.querySelectorAll('.modal-close');

    closeButtons.forEach(button => {
        button.addEventListener('click', function () {

            const modal = this.closest('.modal');

            modal.classList.add('opacity-0');
            modal.classList.add('pointer-events-none');
        });
    });

    // CLOSE WHEN CLICKING OVERLAY
    const overlays = document.querySelectorAll('.modal-overlay');

    overlays.forEach(overlay => {
        overlay.addEventListener('click', function () {

            const modal = this.closest('.modal');

            modal.classList.add('opacity-0');
            modal.classList.add('pointer-events-none');
        });
    });

});
</script>
@include('partials.footer')
