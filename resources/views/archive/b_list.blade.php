@include('partials.adminnav')
<div class="bg-gray-800 rounded-xl shadow-xl p-6 mt-4 mx-4 text-white">

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
    <div class="mb-5">
        <input type="text" id="borrowSearch" placeholder="Search student, title, or book number..."
            class="w-full md:w-96 px-4 py-3 rounded-lg bg-gray-800 border text-white border-gray-600 focus:border-white focus:outline-none">
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
                    <th class="px-6 py-4">Return Date</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody id="borrowTableBody">
                @forelse ($borrows as $borrow)
                    <tr class="border-t border-gray-700 hover:bg-gray-700/40 transition"
                        data-b_no="{{ strtolower($borrow->b_no) }}"
                        data-b_name="{{ strtolower($borrow->b_name) }}"
                        data-s_name="{{ strtolower($borrow->s_name) }}">

                        <td class="px-6 py-4 font-semibold">{{ $borrow->b_no }}</td>
                        <td class="px-6 py-4">{{ $borrow->b_name }}</td>
                        <td class="px-6 py-4">{{ $borrow->s_name }}</td>
                        <td class="px-6 py-4">{{ $borrow->b_date }}</td>
                        <td class="px-6 py-4">{{ $borrow->r_date ? $borrow->r_date : 'Not Set' }}</td>

                        <td class="px-6 py-4 text-center">
                            @if($borrow->status == '0')
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-600 text-white">Borrowed</span>
                            @elseif($borrow->status == '1')
                                <span class="px-3 py-1 rounded-full text-xs bg-green-600 text-white">Returned</span>
                            @elseif($borrow->status == '2')
                                <span class="px-3 py-1 rounded-full text-xs bg-red-600 text-white">Overdue</span>
                            @endif
                        </td>

                       <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2 text-black">
                                <button type="button"
                                    onclick="openBorrowModal({{ $borrow->id }}, '{{ $borrow->b_no }}', '{{ $borrow->b_name }}', '{{ $borrow->s_name }}', '{{ $borrow->b_date ? \Carbon\Carbon::parse($borrow->b_date)->format('Y-m-d\TH:i') : '' }}', '{{ $borrow->r_date ? \Carbon\Carbon::parse($borrow->r_date)->format('Y-m-d\TH:i') : '' }}', '{{ $borrow->status }}', 'view')"
                                    class="px-3 py-2 bg-blue-700 rounded-lg hover:bg-blue-100">
                                    View
                                </button>

                                @if (strtolower($borrow->status) !== '1')
                                    <button type="button"
                                        onclick="openBorrowModal({{ $borrow->id }}, '{{ $borrow->b_no }}', '{{ $borrow->b_name }}', '{{ $borrow->s_name }}', '{{ $borrow->b_date ? \Carbon\Carbon::parse($borrow->b_date)->format('Y-m-d\TH:i') : '' }}', '{{ $borrow->r_date ? \Carbon\Carbon::parse($borrow->r_date)->format('Y-m-d\TH:i') : '' }}', '{{ $borrow->status }}', 'edit')"
                                        class="px-3 py-2 bg-yellow-400 hover:bg-yellow-100 rounded-lg">
                                        Edit
                                    </button>

                                    <form action="{{ route('items.destroy', $borrow->id) }}" method="POST" id="deleteForm-{{ $borrow->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $borrow->id }})"
                                            class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="noResultsRow">
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

<div id="editBorrowModal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-gray-800 text-white w-10/12 md:w-full mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content bg-gray-800 rounded shadow-xl w-full">

            <div class="bg-gray-800 px-6 py-4 border-b border-gray-700">
                <h2 id="modal-title-heading" class="text-xl font-semibold text-white">
                    Borrow Record
                </h2>
            </div>

            <div class="p-6 bg-gray-800 text-white">
                <form id="editBorrowForm" action="/admin/dashboard/borrow/list/" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-3 gap-6 sm:grid-cols-12">
                        <div class="col-span-12 sm:col-span-12">
                            <label class="pl-2" for="modal-b_name">Book Name</label>
                            <input id="modal-b_name" name="b_name" type="text" readonly
                                class="modal-field block w-full px-4 py-2 mt-2 border border-black rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white focus:outline-none focus:ring">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-12">
                        <div class="col-span-12 sm:col-span-12">
                            <label class="pl-2" for="modal-s_name">Student Name</label>
                            <input id="modal-s_name" name="s_name" type="text" readonly
                                class="modal-field block w-full px-4 py-2 mt-2 border border-black rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white focus:outline-none focus:ring">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-4 sm:grid-cols-12">
                        <div class="col-span-12 sm:col-span-3">
                            <label class="pl-2" for="modal-b_date">Borrow Date</label>
                            <input id="modal-b_date" name="b_date" type="datetime-local" readonly
                                class="modal-field block w-full px-4 py-2 mt-2 border border-black rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white focus:outline-none focus:ring">
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label class="pl-2" for="modal-r_date">Return Date</label>
                            <input id="modal-r_date" name="r_date" type="datetime-local"
                                class="modal-field block w-full px-4 py-2 mt-2 border border-black rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white focus:outline-none focus:ring">
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label class="pl-2" for="modal-b_no">Borrow No.</label>
                            <input id="modal-b_no" name="b_no" type="text" readonly
                                class="block w-full px-4 py-2 mt-2 border border-black rounded-md bg-gray-200 bg-gray-800 text-gray-300 border-gray-600 focus:border-white focus:outline-none focus:ring">
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label class="pl-2 font-semibold flex items-center gap-2" for="modal-status">
                                Status
                                <span id="modal-status-badge" class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded-full hidden">Editable</span>
                            </label>
                            <select id="modal-status" name="status"
                                class="modal-field block w-full px-3 py-2 mt-2 border-2 rounded-md  focus:outline-none bg-gray-800 text-gray-300 border-gray-600 focus:border-white">
                                <option value="0">Borrowed</option>
                                <option value="1">Returned</option>
                                <option value="2">Overdue</option>
                            </select>
                        </div>
                    </div>

                    <div class="px-6 py-4 mt-6 -mx-6 -mb-6 border-t flex justify-end gap-2">
                        <button type="button" onclick="closeBorrowModal()"
                            class="modal-close px-5 py-2 bg-danger hover:bg-gray-700 text-white rounded hover:bg-gray-600">
                            Back
                        </button>

                        <button type="submit" id="updateBtn"
                            class="hidden px-5 py-2 bg-blue-900 text-white rounded hover:bg-gray-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('partials.notif')
<script>
    function openBorrowModal(id, b_no, b_name, s_name, b_date, r_date, status, mode) {
        document.getElementById('editBorrowForm').action = '/admin/dashboard/borrow/list/' + id;
        document.getElementById('modal-b_no').value = b_no;
        document.getElementById('modal-b_name').value = b_name;
        document.getElementById('modal-s_name').value = s_name;
        document.getElementById('modal-b_date').value = b_date;
        document.getElementById('modal-r_date').value = r_date;
        document.getElementById('modal-status').value = status;

        const isEdit = mode === 'edit';

        document.querySelectorAll('#editBorrowForm .modal-field').forEach(field => {
            field.disabled = !isEdit;
        });

        document.getElementById('modal-title-heading').textContent =
            isEdit ? 'Borrow Record (Edit)' : 'Borrow Record (View)';

        document.getElementById('updateBtn').classList.toggle('hidden', !isEdit);
        document.getElementById('modal-status-badge').classList.toggle('hidden', !isEdit);

        const modal = document.getElementById('editBorrowModal');
        modal.classList.remove('opacity-0', 'pointer-events-none');
    }

    function closeBorrowModal() {
        const modal = document.getElementById('editBorrowModal');
        modal.classList.add('opacity-0', 'pointer-events-none');
    }

    document.querySelectorAll('#editBorrowModal .modal-overlay, #editBorrowModal .modal-close').forEach(el => {
        el.addEventListener('click', closeBorrowModal);
    });

    // Confirm before submitting the update
    document.getElementById('editBorrowForm').addEventListener('submit', function (e) {
        const confirmed = confirm('Are you sure you want to update this record?');
        if (!confirmed) {
            e.preventDefault();
        }
    });
</script>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
            document.getElementById('deleteForm-' + id).submit();
        }
    }
</script>

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

        // Optional: show a "no results" message dynamically if all rows are hidden
        let dynamicNoResults = document.getElementById('dynamicNoResults');
        if (visibleCount === 0) {
            if (!dynamicNoResults) {
                const tbody = document.getElementById('borrowTableBody');
                const tr = document.createElement('tr');
                tr.id = 'dynamicNoResults';
                tr.innerHTML = `<td colspan="7" class="text-center py-4 text-gray-400">No matching records found.</td>`;
                tbody.appendChild(tr);
            }
        } else if (dynamicNoResults) {
            dynamicNoResults.remove();
        }
    });
</script>
