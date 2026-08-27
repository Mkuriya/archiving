@include('partials.adminnav')
<div class="bg-gray-800 rounded-xl shadow-xl mt-4 mx-4 text-white">
    <div class="bg-gray-800 p-6 my-4 rounded-xl">
    <!-- Header -->
        <div class="grid grid-cols-1 lg:grid-cols-3 items-center gap-4">
            <!-- Left: Title -->
            <h2 class="text-2xl font-bold text-white whitespace-nowrap justify-self-start">
                 📚 Thesis Log Book
            </h2>

            <!-- Center: Search -->
            <form method="GET" action="" class="w-full flex justify-center">
                <div class="relative w-full sm:w-72 lg:w-80">
                    <!-- Left search icon (decorative) -->
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                        </svg>
                    </span>

                    <input type="text" id="borrowSearch" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Search..." class="w-full pl-10 pr-20 py-3 rounded-lg bg-white border border-gray-300 text-gray-800 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">

                    <!-- Right-side buttons: clear (if searching) + submit -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 gap-1">
                        @if(request('search'))
                            <button type="button" onclick="window.location.href='{{ url()->current() }}'"  class="flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-md transition" title="Clear search">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif

                        <button type="submit" class="flex items-center justify-center w-8 h-8 text-white bg-blue-700 hover:bg-blue-800 active:bg-blue-900 rounded-md shadow-sm transition" title="Search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right: Add New button -->
            <a href="/admin/dashboard/logbook"
                class="px-5 py-2 bg-blue-900 hover:bg-gray-700 text-white rounded-lg transition text-center whitespace-nowrap justify-self-end">
                + Add New
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-700">
        <table class="w-full text-sm text-left text-white">

            <thead class="bg-gray-900 text-gray-200 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Book No.</th>
                    <th class="px-6 py-4">Research Title</th>
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Borrow Date</th>
                </tr>
            </thead>

            <tbody id="borrowTableBody">

             @forelse ($list as $borrow)
                    <tr class="border-t border-gray-700 hover:bg-gray-700/40 transition"
                        data-b_no="{{ strtolower($borrow->b_no) }}"
                        data-b_name="{{ strtolower($borrow->b_name) }}"
                        data-s_name="{{ strtolower($borrow->s_name) }}">

                        <td class="px-6 py-4 font-semibold">{{ $borrow->b_no }}</td>
                        <td class="px-6 py-4">{{ $borrow->b_name }}</td>
                        <td class="px-6 py-4">{{ $borrow->s_name }}</td>
                        <td class="px-6 py-4">{{ $borrow->date }}</td>
                    </tr>
                @empty
                    <tr id="noResultsRow">
                        <td colspan="4" class="text-center py-4 text-gray-400">
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

@include('partials.notif')
<script>
    document.getElementById('borrowSearch').addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#borrowTableBody tr');

        let visibleCount = 0;

        rows.forEach(row => {
            if (row.id === 'noResultsRow') return;

            const b_no = row.dataset.b_no || '';
            const b_name = row.dataset.b_name || '';
            const s_name = row.dataset.s_name || '';

            const matches = b_no.includes(query) || b_name.includes(query) || s_name.includes(query);

            row.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });

        // Show a "no results" message dynamically if all rows are hidden
        let dynamicNoResults = document.getElementById('dynamicNoResults');
        if (visibleCount === 0) {
            if (!dynamicNoResults) {
                const tbody = document.getElementById('borrowTableBody');
                const tr = document.createElement('tr');
                tr.id = 'dynamicNoResults';
                tr.innerHTML = `<td colspan="4" class="text-center py-4 text-gray-400">No matching records found.</td>`;
                tbody.appendChild(tr);
            }
        } else if (dynamicNoResults) {
            dynamicNoResults.remove();
        }
    });
</script>
