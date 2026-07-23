@include('partials.adminnav')
<div class="min-h-screen  p-6 ">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">
                NAAP Library Archive Dashboard
            </h1>
            <p class="text-white mt-2">
                Welcome back, {{ auth()->guard('admin')->user()->firstname }}.
            </p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Total Research -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">
                        📚
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Research Papers
                        </p>
                        <h2 class="text-xl font-bold text-gray-800 mt-1">
                            {{ $totalUpload }}
                        </h2>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-5">
                    ↑ Total uploaded
                </p>
            </div>
            <!-- Pending -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">
                        ⏳
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Pending Reviews
                        </p>
                        <h2 class="text-xl font-bold text-gray-800 mt-1">
                             {{ $totalPending }}
                        </h2>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-5">
                    Waiting approval
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <!-- Card 1 -->
                <div class="bg-white rounded-2xl shadow-sm border p-6 cursor-pointer hover:shadow-md transition" onclick="printArchive()">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">
                            🖨
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">
                                Print
                            </p>
                            <h2 class="text-xl font-bold text-gray-800 mt-1">
                                Thesis List
                            </h2>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">
                        Click to Print All List of Thesis.
                    </p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">
                            🚧
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">
                                Borrow Book
                            </p>
                            <h2 class="text-xl font-bold text-gray-800 mt-1">
                                00001
                            </h2>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">
                        This feature is temporarily unavailable.
                    </p>
                </div>
            </div>
        </div>
    <!-- Main Grid -->

    <div class="grid lg:grid-cols-3 gap-6 mt-8">

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50">
                <h2 class="font-semibold text-lg text-gray-800">
                    Recent Uploads
                </h2>

                <a href="/admin/dashboard/archive/pending"
                class="text-sm text-blue-600 hover:underline">
                    View All
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="text-left text-gray-500 border-b bg-white">
                        <tr>
                            <th class="px-6 py-3 w-16 text-center">Book Number</th>
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3 text-right w-32">Year</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($recentUploads as $upload)
                            <tr class="hover:bg-gray-50">

                                <!-- Book Number -->
                                <td class="px-6 py-4 font-medium text-gray-700 text-center whitespace-nowrap">
                                    {{ $upload->book_number }}
                                </td>

                                <!-- Title + Author -->
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">
                                        {{ $upload->title }}
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        {{ $upload->author }}
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 text-right text-gray-400 whitespace-nowrap">
                                    {{ $upload->year }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                    No recent uploads.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="font-bold text-xl mb-5">
                Quick Actions
            </h2>
            <div class="space-y-4">
                <a href="/admin/dashboard/thesis/upload"class="flex items-center justify-between bg-blue-50 p-4 rounded-xl hover:bg-blue-100">
                    <div>
                        <h3 class="font-semibold">
                            Upload Research
                        </h3>
                        <p class="text-sm text-gray-500">
                            Add a new research paper
                        </p>
                    </div>
                    📤
                </a>

                <a href="/admin/dashboard/archive" class="flex items-center justify-between bg-green-50 p-4 rounded-xl hover:bg-green-100">
                    <div>
                        <h3 class="font-semibold">
                            Archive
                        </h3>
                        <p class="text-sm text-gray-500">
                            Browse archived papers
                        </p>
                    </div>
                    📁
                </a>
                <a href="/admin/dashboard/borrow" class="flex items-center justify-between bg-yellow-50 p-4 rounded-xl hover:bg-yellow-100">
                    <div>
                        <h3 class="font-semibold">
                            Borrow Books
                        </h3>
                        <p class="text-sm text-gray-500">
                            Manage books
                        </p>
                    </div>
                    👨‍🎓
                </a>
                <a href="/admin/dashboard/search" class="flex items-center justify-between bg-purple-50 p-4 rounded-xl hover:bg-purple-100">
                    <div>
                        <h3 class="font-semibold">
                            Search
                        </h3>
                        <p class="text-sm text-gray-500">
                            Search archived research
                        </p>
                    </div>
                    🔍
                </a>
                <a href="/admin/dashboard/instructor" class="flex items-center justify-between bg-purple-50 p-4 rounded-xl hover:bg-purple-100">
                    <div>
                        <h3 class="font-semibold">
                            Instructor
                        </h3>
                        <p class="text-sm text-gray-500">
                            Search archived research
                        </p>
                    </div>
                    🔍
                </a>


            </div>
        </div>
    </div>
</div>

@extends('partials.footer')
