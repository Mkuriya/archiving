@include('partials.adminnav')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"></script>

<div class="w-full flex justify-center items-end fixed bottom-0 left-0">
    <div id="search-bar" class="w-full sm:w-1/2 bg-white rounded-md shadow-lg z-10 mb-4">
        <form id="search-form" class="flex items-center justify-between p-2">
             <!-- New Search / Reset Button -->
            <button type="button"
                onclick="newSearch()"
                class="bg-blue-900 hover:bg-gray-600 text-white rounded-md py-2 px-4 ml-2">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M23 4v6h-6"></path>
                    <path d="M1 20v-6h6"></path>
                    <path d="M3.5 9a9 9 0 0 1 14.85-3.36L23 10"></path>
                    <path d="M1 14l4.65 4.36A9 9 0 0 0 20.5 15"></path>
                </svg>
            </button>
            <input id="search-input"  type="text" placeholder="Search here" class="text-xl py-2 px-4 border-0 bg-white text-sm placeholder:text-gray-800 focus:outline-none focus:ring-0 w-full" autocomplete="off" >
            <!-- Search Button -->
            <button type="submit" class="bg-blue-900 hover:bg-blue-700 text-white rounded-md py-2 px-4 ml-2">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>


        </form>
    </div>
</div>
{{--
<div id="results-container" class="w-full flex flex-col items-center mt-6">
    <div id="results-container" class="w-full items-center justify-center mt-6 min-h-[650px]">
        <p id="default-message" class="text-white text-5xl text-center font-calligraphy">
        Start your search to explore available archive records.
        </p>
    </div>
</div>

--}}



<div class="w-full  flex flex-col items-center mt-6">
    <div id="results-container" class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3 sm:pl-12  items-center justify-center mt-6 min-h-[650px]">

            <p id="default-message" class="col-span-5 text-white text-5xl text-center font-calligraphy sm:pl-12">
                Start your search to explore available archive records.
            </p>

            <p class="col-span-5  text-gray-300 text-lg text-center mt-4 font-sans sm:pl-12">
                Reminder: Use keywords only (e.g., title, author, adviser, or publication year).
            </p>
    </div>
</div>



<style>
    .highlight {
        background-color: #feffc8;
        border-radius: 4px;
        padding: 2px;
        font-weight: bold;
        color:black;
    }

    #results-container {
        max-height: 120px;
        overflow-y: auto;
    }

    .result-item {
        margin-bottom: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 0 0.25rem rgba(0, 0, 0, 0.1);
    }

    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #503030;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        transition: opacity 0.5s ease-in-out;
    }
</style>

<script>
    document.getElementById('search-form')
    .addEventListener('submit', function(e){
        e.preventDefault();

        let search = document.getElementById('search-input').value.trim();
        let result = document.getElementById('results-container');

        // Show default message if no search keyword
        if(search === "") {
            result.innerHTML = `
                <p class="text-gray-500 text-lg mt-10">
                    Search details here...
                </p>`;
            return;
        }

        fetch(`/archive/search-result?search=${encodeURIComponent(search)}`)
        .then(response => response.json())
        .then(files => {

            result.innerHTML = "";

            if(!files || files.length === 0){
                result.innerHTML = `
                <div class=" p-3
                    col-span-5 text-white text-5xl text-center ">

                    No file found
                </div>`;
                return;
            }

            files.forEach(file => {

                let abstract = file.abstract ?? "";

                result.innerHTML += `
                <div class="w-full sm:w-80 bg-white text-black rounded mb-4 rounded-lg ">
                     <div class="h-20 bg-sky-800 flex justify-center p-3 rounded-lg">
                        <h2 class="text-sm font-bold text-white  line-clamp-3 ">
                            TITLE:  ${highlight(String(file.title), search)}
                        </h2>
                        ${
                            file.adviser == null
                            ? `<span class="ml-2 text-red-600 text-xs font-semibold">
                                    ⚠ Missing Hardcopy
                            </span>`
                            : ''
                        }
                    </div>
                    <div class="p-4 text-gray-700 text-sm flex flex-col h-[270px]">
                        <p>
                            <b>Book Number:</b> ${highlight(String(file.book_number), search)}
                        </p>

                        <p class="mt-1">
                            <b>Year:</b> ${highlight(String(file.year), search)}
                        </p>

                        <p class="mt-1">
                            <b>Department:</b> ${highlight(String(file.department), search)}
                        </p>
                        <p class="mt-1">
                            <b>Members:</b> ${highlight(String(file.members), search)}
                        </p>

                        <p class="mt-1">
                            <b>Adviser:</b> ${highlight(String(file.adviser), search)}
                        </p>


                        <a href="/admin/dashboard/search/details/${file.id}"
                        class="mt-auto text-center bg-blue-700 text-white py-2 rounded-lg hover:bg-sky-800">
                            View Details
                        </a>

                    </div>
                </div>`;
            });
        })
        .catch(error => {
            console.log(error);
            result.innerHTML =
            `<div class="bg-red-300 p-3 rounded">Error loading results</div>`;
        });
    });

    function highlight(text, keyword){

        if(!keyword || !text) return text;

        let regex = new RegExp(
            `(${keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`,
            "gi"
        );

        return text.replace(
            regex,
            `<span class="highlight">$1</span>`
        );
    }

    function newSearch() {
        document.getElementById('search-input').value = '';
        window.location.reload();
    }
</script>
