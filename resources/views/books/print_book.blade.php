<style>
    @media print {
        .no-print {
            display: none !important;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        h3 {
            page-break-after: avoid;
        }
    }

    table {
        font-size: x-small;
    }
</style>

<div class="no-print">
    @include('partials.adminnav')
</div>

<div class="mx-auto max-w-7xl bg-white p-8 text-[11pt] font-sans text-black">

    <h2 class="mb-6 text-center text-2xl font-bold uppercase">
        Instructor Book Assignments
    </h2>

    @forelse($assignments as $instructorAssignments)

        @php
            $instructor = $instructorAssignments->first()->instructor;
        @endphp

        <div class="mb-8">

            <h3 class="mb-2 text-base font-bold uppercase border-b border-black pb-1">
                {{ $instructor->name }}
            </h3>

            <table class="w-full table-fixed border-collapse border border-black">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="w-[8%] border border-black px-2 py-2 text-center font-bold">
                            No.
                        </th>

                        <th class="w-[15%] border border-black px-2 py-2 text-center font-bold">
                            Book No.
                        </th>

                        <th class="w-[77%] border border-black px-2 py-2 text-center font-bold">
                            Title
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($instructorAssignments as $assignment)
                        <tr class="align-top">

                            <td class="border border-black px-2 py-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border border-black px-2 py-2 text-center">
                                {{ $assignment->file->book_number }}
                            </td>

                            <td class="border border-black px-2 py-2">
                                {{ $assignment->file->title }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    @empty
        <p class="text-center text-gray-500">No instructor assignments found.</p>
    @endforelse

</div>
