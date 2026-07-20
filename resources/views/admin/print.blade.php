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
    }
    table{
        font-size: x-small;
    }
</style>

<div class="no-print">
    @include('partials.adminnav')
{{--
    <button
        onclick="window.print()"
        class=" rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
        🖨 Print Archive List
    </button>--}}
</div>

<div class="mx-auto max-w-7xl bg-white p-8 text-[11pt] font-sans text-black">

    <h2 class="mb-6 text-center text-2xl font-bold uppercase">
        Archive List
    </h2>

    <table class="w-full table-fixed border-collapse border border-black ">

        <thead class="bg-gray-100">
            <tr>
                <th class="w-[7%] border border-black px-2 py-2 text-center font-bold">
                    Book No.
                </th>

                <th class="w-[33%] border border-black px-2 py-2 text-center font-bold">
                    Title
                </th>

                <th class="w-[7%] border border-black px-2 py-2 text-center font-bold">
                    Year
                </th>

                <th class="w-[15%] border border-black px-2 py-2 text-center font-bold">
                    Department
                </th>

                <th class="w-[23%] border border-black px-2 py-2 text-center font-bold">
                    Members
                </th>

                <th class="w-[15%] border border-black px-2 py-2 text-center font-bold">
                    Adviser
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach($files as $item)
                <tr class="align-top">

                    <td class="border border-black px-2 py-2 text-center">
                        {{ $item->book_number }}
                    </td>

                    <td class="border border-black px-2 py-2">
                        {{ $item->title }}
                    </td>

                    <td class="border border-black px-2 py-2 text-center">
                        {{ $item->year }}
                    </td>

                    <td class="border border-black px-2 py-2">
                        {{ $item->department }}
                    </td>

                    <td class="border border-black px-2 py-2">
                        {{ $item->members }}
                    </td>

                    <td class="border border-black px-2 py-2">
                        {{ $item->adviser }}
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

</div>
