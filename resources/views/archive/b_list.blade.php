@include('partials.adminnav')
<div class="bg-white rounded-xl shadow-xl p-6 mt-4 mx-4">

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold ">
            📚 Borrow Records
        </h2>

        <a href="/admin/dashboard/borrow"
           class="px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition">
            + New Borrow
        </a>
    </div>

    <!-- Search -->
    <div class="mb-5 ">
        <input type="text" placeholder="Search student, title, or book number..." class="w-full md:w-96 px-4 py-3 rounded-lg bg-white border border-gray-700 text-black focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-700">

        <table class="w-full text-sm text-left text-black">

            <thead class="bg-gray-900 text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Book No.</th>
                    <th class="px-6 py-4">Research Title</th>
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Borrow Date</th>
                    <th class="px-6 py-4">Return Date</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
    @forelse ($borrows as $borrow)
        <tr class="border-t border-gray-700 hover:bg-gray-700/40 transition">

            <td class="px-6 py-4 font-semibold">
                {{ $borrow->b_no }}
            </td>

            <td class="px-6 py-4">
                {{ $borrow->b_name }}
            </td>

            <td class="px-6 py-4">
                {{ $borrow->s_name }}
            </td>

            <td class="px-6 py-4">
                {{ $borrow->b_date }}
            </td>

           <td class="px-6 py-4">
    {{ $borrow->r_date ? $borrow->r_date : 'Not Set' }}
</td>

            <td class="px-6 py-4 text-center">
                @if($borrow->status == '0')
                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-600 text-white">
                        Borrowed
                    </span>

                @elseif($borrow->status == '1')
                    <span class="px-3 py-1 rounded-full text-xs bg-green-600 text-white">
                        Returned
                    </span>

                @elseif($borrow->status == '2')
                    <span class="px-3 py-1 rounded-full text-xs bg-red-600 text-white">
                        Overdue
                    </span>
                @endif
            </td>

            <td class="px-6 py-4 text-center">
                <div class="flex justify-center gap-2 text-black">

                    <a href="/admin/dashboard/borrow/{{ $borrow->id }}"
                       class="px-3 py-2 bg-blue-400 rounded-lg hover:bg-blue-800">
                        View
                    </a>

                    <a href="/admin/dashboard/borrow/edit/{{ $borrow->id }}"
                       class="px-3 py-2 bg-yellow-400 rounded-lg">
                        Edit
                    </a>

                    <form action="/admin/dashboard/borrow/{{ $borrow->id }}"
                          method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="px-3 py-2 rounded-lg bg-red-400">
                            Delete
                        </button>
                    </form>

                </div>
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-4 text-gray-400">
                No borrow records found.
            </td>
        </tr>
    @endforelse
</tbody>

        </table>

    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{-- $borrows->links() --}}
    </div>

</div>
