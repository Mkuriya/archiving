@include('partials.adminnav')
<div class="">
    <section class="max-w-screen-2xl p-6 mx-auto">
        <div class="grid grid-cols-1 gap-4 pt-4 sm:grid-cols-8">
            <div class="sm:col-span-5 col-span-8">
                <a href="/admin/dashboard/admin/register">
                    <button class="ml-4 bg-blue-700 px-5  py-3 rounded-2xl text-white dark:hover:text-indigo-500">Register Admin</button>
                </a>
            </div>
            <div class="mb-2 mr-4 text-white sm:col-span-3 col-span-8 ">
                <form action="{{ url('/admin/dashboard/admin') }}" id="searchForm" method="get" class="max-w-md mx-auto">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center p-2">
                            <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>

                        <div class="relative ">
                            <!-- Search Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400"fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.15z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" value="{{ request()->input('search') }}" name="search" class="w-full pl-12 pr-28 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl shadow-sm focus:ring-2 focus:ring-gray-800 focus:border-gray-800 outline-none transition" placeholder="Search research, author, title..."/>


                            <button type="submit" class="absolute right-2 top-2 bg-white text-black  px-5 py-2.5 rounded-xl font-medium hover:text-white hover:bg-gray-800 transition">
                                Search
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-col">
           <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 ">
                 <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-800">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-400">
                                        <div class="flex items-center gap-x-3">
                                            <button class="flex items-center gap-x-2">
                                                <span>Name</span>
                                            </button>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-400">
                                        Gender
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-400">
                                        Email
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-400">
                                        Photo
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-400">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class=" divide-y divide-gray-700 bg-gray-900">
                                @if($admins->isEmpty())
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-sm font-medium text-gray-200 whitespace-nowrap text-center">
                                            No data found.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($admins as $item)
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-200 whitespace-nowrap">
                                                <div class="inline-flex items-center gap-x-3">
                                                    <span>{{$item->lastname}}, {{$item->firstname}} {{$item->middlename}}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-300 whitespace-nowrap">{{$item->gender}}</td>
                                            <td class="px-4 py-4 text-sm text-gray-300 whitespace-nowrap">
                                                <h2 class="text-sm font-normal">{{$item->email}}</h2>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-300 whitespace-nowrap">
                                                <div class="flex items-center gap-x-2">
                                                    <img class="object-cover w-10 h-10 " src="{{ asset('storage/' . $item->photo) }}" alt="">
                                                </div>
                                            </td>
                                            <td class="px-1 py-4 text-sm whitespace-nowrap">
                                                <div class="flex items-center gap-x-6">
                                                    <a href="/admin/dashboard/admin/view/{{$item->id}}" title="View Admin">
                                                        <button class="transition-colors duration-200 hover:text-whitebg text-gray-300  focus:outline-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                </svg>
                                                        </button>
                                                    </a>
                                                    <a href="/admin/dashboard/admin/edit/{{$item->id}}" title="Edit Admin">
                                                        <button onclick="return confirm('Update the data?');" class="transition-colors duration-200 hover:text-whitebg text-gray-300  focus:outline-none">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                            </svg>
                                                        </button>
                                                    </a>
                                                    @if(auth()->guard('admin')->user()->id == 1)
                                                        <form action="/admin/dashboard/admin/delete/{{$item->id}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('Permanent Delete?');" class="text-red-700 transition-colors duration-200 hover:text-white focus:outline-none sm:pr-0 pr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"  fill="none"  viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"  stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M10 11v6M14 11v6M9 7V4h6v3M4 7h16"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>

                    </div>
                    <nav aria-label="Page navigation example" class="mt-4 grid justify-items-center">
                        <div class="flex">
                            <!-- Conditional display of Previous Button -->
                            @if ($admins->lastPage() > 1)
                                @if ($admins->onFirstPage())
                                    <span class="flex items-center justify-center mr-3 px-3 h-8 text-sm font-medium text-gray-500  border rounded-lg bg-gray-800 border-gray-700 text-gray-400">Previous</span>
                                @else
                                    <a href="{{ $admins->previousPageUrl() }}" class="flex mr-3 items-center justify-center px-3 h-8 text-sm font-medium text-gray-500  border rounded-lg border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">Previous</a>
                                @endif
                            @endif

                            <!-- Pagination Links -->
                            <ul class="flex items-center -space-x-px h-8 text-sm">
                                @if ($admins->hasPages())
                                    @foreach ($admins->links()->elements as $element)
                                        @if (is_string($element))
                                            <li>
                                                <span class="flex items-center justify-center px-3 h-8 leading-tight border bg-gray-800 border-gray-700 text-gray-400">{{ $element }}</span>
                                            </li>
                                        @endif
                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $admins->currentPage())
                                                    <li>
                                                        <span class="flex items-center justify-center px-3 h-8 leading-tight border bg-gray-800 border-gray-700 text-gray-400">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ $url }}" class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </ul>

                            <!-- Conditional display of Next Button -->
                            @if ($admins->lastPage() > 1)
                                @if ($admins->hasMorePages())
                                    <a href="{{ $admins->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg hover:bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">Next</a>
                                @else
                                    <span class="flex items-center justify-center px-3 h-8 ml-3 text-sm font-medium border rounded-lg bg-gray-800 border-gray-700 text-gray-400">Next</span>
                                @endif
                            @endif
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </section>
</div>
<!-- Success/Error Message Container -->
<div class="fixed bottom-4 right-4 z-50 w-96">
    @if(session('success'))
        <div class="bg-gray-200 p-4 rounded relative alert" role="alert">
            {{ session('success') }}
            <button type="button" class="absolute top-0 right-0 mt-2 mr-4 text-lg text-gray-600 hover:text-gray-800" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @elseif(session('error'))
        <div class="bg-sky-500 p-4 rounded relative alert" role="alert">
            {{ session('error') }}
            <button type="button" class="absolute top-0 right-0 mt-2 mr-4 text-lg text-gray-600 hover:text-gray-800" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif
</div>
@extends('partials.footer')
