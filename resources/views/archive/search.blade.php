@include('partials.adminnav')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"></script>

<style>
    .ai-search { --ink:#0f1c2e; --steel:#3b6e9c; --sky:#9cc9e8; --cyan:#dff3f7; --coral:#ff7a66; }

    .ai-search {
        min-height: 650px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 1rem 1rem;
        overflow-x: hidden;
        position: relative;
        isolation: isolate;
    }
    /* soft aurora glow behind the search area */
    .ai-search::before {
        content: "";
        position: absolute; inset: 0 0 auto 0; height: 520px; z-index: -1;
        background:
            radial-gradient(600px 260px at 25% 30%, rgba(59,110,156,.45), transparent 70%),
            radial-gradient(500px 240px at 75% 20%, rgba(255,122,102,.22), transparent 70%),
            radial-gradient(500px 260px at 50% 70%, rgba(156,201,232,.18), transparent 70%);
        filter: blur(10px);
    }

    /* hero: centered when idle, slides up after a search */
    .ai-hero {
        width: 100%; max-width: 760px;
        padding-top: 30vh;
        transition: padding-top .5s cubic-bezier(.2,.8,.2,1);
        text-align: center;
    }
    .ai-search.has-results .ai-hero { padding-top: 2.5rem; }
    .ai-search.has-results .ai-intro { display: none; }

    .ai-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .85rem; border-radius: 999px;
        font-size: .75rem; letter-spacing: .04em;
        color: var(--cyan); background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.14);
        backdrop-filter: blur(6px);
    }
   
    .ai-title {
        margin-top: 1.25rem;
        font-size: clamp(2rem, 5vw, 3.25rem);
        font-weight: 700; line-height: 1.1; color: #fff;
        letter-spacing: -.02em;
    }
    .ai-title span {
        background: linear-gradient(90deg, var(--sky), var(--coral));
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .ai-sub { margin-top: .75rem; color: rgba(223,243,247,.75); font-size: 1rem; }

    /* the search box */
    .ai-box {
        margin-top: 2rem;
        display: flex; align-items: center; gap: .5rem;
        padding: .5rem .5rem .5rem 1.1rem;
        background: rgba(255,255,255,.96);
        border-radius: 999px;
        box-shadow: 0 10px 40px rgba(8,20,40,.35), 0 0 0 1px rgba(255,255,255,.4);
        transition: box-shadow .25s, transform .25s;
    }
    .ai-box:focus-within {
        box-shadow: 0 14px 50px rgba(8,20,40,.45), 0 0 0 3px rgba(156,201,232,.7);
        transform: translateY(-1px);
    }
    .ai-box input {
        flex: 1; min-width: 0; border: 0; outline: 0; background: transparent;
        font-size: 1rem; color: #0f1c2e; padding: .6rem .25rem;
    }
    .ai-box input:focus { outline: none; box-shadow: none; }
    .ai-box input::placeholder { color: #7a8aa0; }
    .ai-ico { width: 22px; height: 22px; color: #7a8aa0; flex: none; }
    .ai-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 44px; height: 44px; border-radius: 50%; border: 0; cursor: pointer; flex: none;
        transition: transform .15s, background .2s;
    }
    .ai-btn:active { transform: scale(.94); }
    .ai-btn svg { width: 20px; height: 20px; }
    .ai-btn.go { background: var(--coral); color: #fff; }
    .ai-btn.go:hover { background: #ff6149; }
    .ai-btn.ghost { background: #eef3f8; color: #3b6e9c; display: none; }
    .ai-btn.ghost:hover { background: #dfe9f3; }

    .ai-chips { margin-top: 1rem; display: flex; flex-wrap: wrap; justify-content: center; gap: .5rem; }
    .ai-chip {
        font-size: .8rem; padding: .35rem .8rem; border-radius: 999px;
        color: var(--cyan); background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.13);
    }
    .ai-tip { margin-top: 1rem; font-size: .8rem; color: rgba(223,243,247,.55); }

    /* status line */
    .ai-status {
        width: 100%; max-width: 1400px; margin: 2rem auto 1rem;
        color: rgba(223,243,247,.8); font-size: .9rem;
        display: none; align-items: center; gap: .6rem;
    }
    .ai-status b { color: #fff; }

    /* results */
    .ai-results {
        width: 100%; max-width: 1400px;
        display: grid; gap: 1rem;
        grid-template-columns: 1fr;
    }
    @media (min-width: 640px)  { .ai-results { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 900px)  { .ai-results { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 1024px) { .ai-results { grid-template-columns: repeat(5, 1fr); } }
    .ai-card {
        display: flex; flex-direction: column;
        background: rgba(255,255,255,.97); color: #1e2b3c;
        border-radius: 1rem; overflow: hidden;
        box-shadow: 0 6px 24px rgba(8,20,40,.25);
        border: 1px solid rgba(255,255,255,.5);
        transition: transform .2s, box-shadow .2s;
        animation: ai-rise .45s both;
    }
    .ai-card:hover { transform: translateY(-4px); box-shadow: 0 14px 34px rgba(8,20,40,.38); }
    .ai-card-head {
        padding: 1rem 1.1rem .9rem;
        background: linear-gradient(135deg, #2f5f8c, #3b6e9c);
        color: #fff;
    }
    .ai-card-head h2 {
        font-size: .95rem; font-weight: 700; line-height: 1.35;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .ai-warn {
        display: inline-flex; align-items: center; gap: .3rem; margin-top: .6rem;
        font-size: .7rem; font-weight: 600; padding: .15rem .55rem; border-radius: 999px;
        background: #ffe3de; color: #c2321c;
    }
    .ai-meta { padding: 1rem 1.1rem; display: grid; gap: .6rem; font-size: .85rem; flex: 1; }
    .ai-row { display: flex; flex-direction: column; }
    .ai-row small { font-size: .68rem; text-transform: uppercase; letter-spacing: .06em; color: #7a8aa0; }
    .ai-row span { color: #1e2b3c; word-break: break-word; }
    .ai-pair { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; }
    .ai-link {
        margin: 0 1.1rem 1.1rem; text-align: center; padding: .6rem; border-radius: .7rem;
        background: #eef6fb; color: #2f5f8c; font-weight: 600; font-size: .85rem;
        transition: background .2s, color .2s;
    }
    .ai-card:hover .ai-link { background: var(--coral); color: #fff; }

    .highlight {
        background-color: #feffc8; border-radius: 4px; padding: 0 3px;
        font-weight: 700; color: #000;
    }

    /* skeleton loading */
    .ai-skel {
        height: 300px; border-radius: 1rem;
        background: linear-gradient(100deg, rgba(255,255,255,.08) 30%, rgba(255,255,255,.2) 50%, rgba(255,255,255,.08) 70%);
        background-size: 200% 100%; animation: ai-shimmer 1.2s infinite;
    }
    .ai-empty { grid-column: 1 / -1; text-align: center; padding: 3rem 1rem; color: #fff; }
    .ai-empty h3 { font-size: 1.5rem; font-weight: 700; }
    .ai-empty p { margin-top: .4rem; color: rgba(223,243,247,.7); }
    .ai-error { grid-column: 1 / -1; background: #ffd9d3; color: #8a1f10; padding: 1rem; border-radius: .75rem; text-align: center; }

    @keyframes ai-rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes ai-shimmer { to { background-position: -200% 0; } }

    @media (min-width: 640px) { .ai-search { padding-left: 3.5rem; } }
</style>

<div id="ai-search" class="ai-search">

    <div class="ai-hero">
        <div class="ai-intro">
            <h1 class="ai-title">What are you <span>looking for?</span></h1>
            <p class="ai-sub">Search research papers by title, author, adviser, or year.</p>
        </div>

        <form id="search-form" class="ai-box" autocomplete="off">
            <svg class="ai-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>

            <input id="search-input" type="text" placeholder="Search the archive..." autocomplete="off" autofocus>

            <!-- New search / reset -->
            <button type="button" id="reset-btn" class="ai-btn ghost" onclick="newSearch()" title="New search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <!-- Search -->
            <button type="submit" class="ai-btn go" title="Search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </form>

        <div class="ai-intro">
            <div class="ai-chips">
                <span class="ai-chip">Title</span>
                <span class="ai-chip">Author</span>
                <span class="ai-chip">Adviser</span>
                <span class="ai-chip">Publication year</span>
            </div>
            <p class="ai-tip">Tip: use keywords only, not full sentences.</p>
        </div>
    </div>

    <div id="ai-status" class="ai-status"></div>
    <div id="results-container" class="ai-results"></div>
</div>

<script>
    const root      = document.getElementById('ai-search');
    const form      = document.getElementById('search-form');
    const input     = document.getElementById('search-input');
    const result    = document.getElementById('results-container');
    const statusEl  = document.getElementById('ai-status');
    const resetBtn  = document.getElementById('reset-btn');

<<<<<<< Updated upstream
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
                            file.adviser == null || !file.adviser
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
=======
    // show the "X" button only when there's text
    input.addEventListener('input', () => {
        resetBtn.style.display = input.value ? 'inline-flex' : 'none';
>>>>>>> Stashed changes
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const search = input.value.trim();
        if (search === "") { resetState(); return; }

        root.classList.add('has-results');
        showLoading();

        fetch(`/archive/search-result?search=${encodeURIComponent(search)}`)
            .then(response => response.json())
            .then(files => {
                if (!files || files.length === 0) {
                    statusEl.style.display = 'none';
                    result.innerHTML = `
                        <div class="ai-empty">
                            <h3>No file found</h3>
                            <p>Nothing matched "${esc(search)}". Try another keyword.</p>
                        </div>`;
                    return;
                }

                statusEl.style.display = 'flex';
                statusEl.innerHTML =
                    `<span><b>${files.length}</b> result${files.length > 1 ? 's' : ''} for <b>"${esc(search)}"</b></span>`;

                result.innerHTML = files.map((file, i) => cardHTML(file, search, i)).join('');
            })
            .catch(error => {
                console.log(error);
                statusEl.style.display = 'none';
                result.innerHTML = `<div class="ai-error">Error loading results. Please try again.</div>`;
            });
    });

    function cardHTML(file, search, i) {
        const missing = file.adviser == null || !file.adviser;

        return `
        <div class="ai-card" style="animation-delay:${Math.min(i, 12) * 40}ms">
            <div class="ai-card-head">
                <h2>${highlight(val(file.title), search)}</h2>
                ${missing ? `<span class="ai-warn">⚠ Missing Hardcopy</span>` : ''}
            </div>

            <div class="ai-meta">
                <div class="ai-pair">
                    <div class="ai-row"><small>Book No.</small><span>${highlight(val(file.book_number), search)}</span></div>
                    <div class="ai-row"><small>Year</small><span>${highlight(val(file.year), search)}</span></div>
                </div>
                <div class="ai-row"><small>Department</small><span>${highlight(val(file.department), search)}</span></div>
                <div class="ai-row"><small>Members</small><span>${highlight(val(file.members), search)}</span></div>
                <div class="ai-row"><small>Adviser</small><span>${highlight(val(file.adviser), search)}</span></div>
            </div>

            <a href="/admin/dashboard/search/details/${file.id}" class="ai-link">View Details</a>
        </div>`;
    }

    function showLoading() {
        statusEl.style.display = 'flex';
        statusEl.innerHTML = 'Searching the archive...';
        result.innerHTML = Array(4).fill('<div class="ai-skel"></div>').join('');
    }

    // escape HTML so titles/names can't break the page
    function esc(text) {
        return String(text)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // empty/null values show a dash instead of "null"
    function val(v) {
        return (v === null || v === undefined || v === '') ? '—' : String(v);
    }

    function highlight(text, keyword) {
        if (!keyword || !text) return esc(text);

        const safeText = esc(text);
        const safeKey  = esc(keyword).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex    = new RegExp(`(${safeKey})`, 'gi');

        return safeText.replace(regex, `<span class="highlight">$1</span>`);
    }

    function resetState() {
        root.classList.remove('has-results');
        result.innerHTML = '';
        statusEl.style.display = 'none';
        statusEl.innerHTML = '';
    }

    // new search: clear everything without reloading the page
    function newSearch() {
        input.value = '';
        resetBtn.style.display = 'none';
        resetState();
        input.focus();
    }
</script>