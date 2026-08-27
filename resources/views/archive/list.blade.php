@include('partials.adminnav')
<div class="content px-10">
    <div class="mt-6 mb-4 md:flex md:items-center md:justify-between">
        <div class="inline-flex overflow-hidden border divide-x rounded-lg rtl:flex-row-reverse border-gray-700 divide-gray-700 bg-white">
            <ul class="flex">
                <li class="mr-3">
                    <a class="inline-block rounded py-1.5 px-3  text-white border-b border-b-4 border-white  bg-gray-900" href="/admin/dashboard/archive">Archive List</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block rounded py-1.5 px-3  text-black  bg-white " href="/admin/dashboard/archive/pending">Pending List</a>
                </li>
                <li class="">
                    <a class="inline-block rounded py-1.5 px-3  text-black  bg-white" href="/admin/dashboard/archive/decline">Decline List</a>
                </li>
            </ul>
        </div>
        <div class="text-white w-full h-12 sm:w-2/6 ">
            <form action="{{ url('/admin/dashboard/archive') }}" id="searchForm" method="GET" action="" class="w-full flex justify-center">
                <div class="relative w-full sm:w-72 lg:w-80">
                    <!-- Left search icon (decorative) -->
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Search research details" class="w-full pl-10 pr-20 py-3 rounded-lg bg-white border border-gray-300 text-gray-800 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr><br>
    <div class="flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 ">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                 <div class="overflow-hidden border border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                 <th scope="col" class="px-4 py-3.5 text-sm font-normal text-center rtl:text-right ">
                                    Book Number
                                </th>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right ">
                                    <div class="flex items-center gap-x-3">
                                        <button class="flex items-center gap-x-2">
                                            <span>Title</span>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">
                                    Year
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">
                                    Department
                                </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right ">
                                    Adviser
                                </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700 bg-white">
                            @forelse ($files as $item)
                                @if ($item->status == 1)
                                    <tr class="hover:bg-gray-800 hover:text-white">
                                        <td class="px-4 py-4 text-sm  whitespace-nowrap text-center">
                                            <h2 class="text-sm font-normal">{{$item->book_number}}</h2>
                                        </td>
                                        <td class="px-4 py-4 text-sm font-medium  whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <span>{{ \Illuminate\Support\Str::words($item->title, 15, '...') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm  whitespace-nowrap">
                                            {{$item->year}}
                                        </td>

                                        <td class="px-4 py-4 text-sm whitespace-nowrap">

                                            <h2 class="text-sm font-normal">{{$item->department}}</h2>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <h2 class="text-sm font-normal">{{$item->adviser}}</h2>
                                                @if (empty(trim($item->adviser ?? '')))
                                                    <span class="ml-2 text-red-600 text-xs font-semibold">
                                                        ⚠ Missing Hardcopy
                                                    </span>
                                                @endif
                                        </td>
                                        <td class="px-1 py-4 text-sm whitespace-nowrap">
                                            <a href="{{ url('/admin/dashboard/archive/details/'.$item->id) }}">
                                                <button class="  hover:text-red-400 font-bold py-2 px-4 rounded-full">View</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-sm font-medium text-black whitespace-nowrap text-center">
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
    document.getElementById('dropdownButton').addEventListener('click', function() {
        document.getElementById('dropdown').classList.toggle('hidden');
    });

    new TomSelect('#dropdown', {
        maxOptions: 5
    });
</script>
@include('partials.footer')
