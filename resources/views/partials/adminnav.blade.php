@include('partials.header')

{{-- Sidebar design (plain CSS, no Tailwind needed). Change the color on the --sb-bg line. --}}{{-- -- --}}
<style>
    :root {
        --sb-bg: #293241;      /* sidebar color: use your primary color's hex here */
        --sb-ink: #c9d4e0;
        --sb-mute: #8fa2b6;
        --sb-w: 240px;


    }
    body{
        margin:0;
        font-family:'Inter',sans-serif;
        color:var(--text);
    }
    .sb, .sb *, .sb *::before, .sb *::after { box-sizing: border-box; }
    .sb {
        position: fixed; top: 0; bottom: 0; left: 0; z-index: 50;
        width: var(--sb-w); padding: 22px 14px;
        display: flex; flex-direction: column; overflow-y: auto;
        background: var(--sb-bg); color: var(--sb-ink);
        font-size: 15px; line-height: 1.5;
        transition: transform .2s;
    }

    /* Brand */
    .sb-brand { display: flex; align-items: center; gap: 10px; padding: 0 10px 18px; color: #fff; }
    .sb-brand svg { width: 28px; height: 28px; flex: none; }
    .sb-brand a { color: #fff; text-decoration: none; font-size: 20px; font-weight: 600; line-height: 1.2; }
    .sb-x { display: none; margin-left: auto; background: none; border: 0; color: #fff; font-size: 30px; line-height: 1; cursor: pointer; }

    /* Name / email */
    .sb-user { display: flex; align-items: center; gap: 10px; padding: 0 10px 6px; }
    .sb-av { width: 36px; height: 36px; flex: none; border-radius: 50%; object-fit: cover; }
    .sb-who { min-width: 0; }
    .sb-who b { display: block; font-size: 17px; font-weight: 400; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sb-who small { display: block; font-size: 12px; color: var(--sb-mute); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* Groups and links */
    .sb-nav { flex: 1; }
    .sb-grp { margin: 14px 10px 4px; font-size: 12px; color: var(--sb-mute); }
    .sb-link {
        display: flex; align-items: center; gap: 11px; width: 100%;
        margin: 0; padding: 9px 10px; border: 0; border-radius: 8px;
        background: none; color: var(--sb-ink); text-decoration: none;
        font: inherit; text-align: left; cursor: pointer;
    }
    .sb-link:hover { background: rgba(255,255,255,.08); }
    .sb-link.on { background: #fff; color: #293241; font-weight: 600; }
    .sb-link svg { width: 18px; height: 18px; flex: none; fill: none; stroke: currentColor; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
    .sb-out { margin: 0; }

    /* Mobile top bar + overlay */
    .sb-bar { position: sticky; top: 0; z-index: 30; height: 56px; display: flex; align-items: center; gap: 12px; padding: 0 16px; background: var(--sb-bg); color: #fff; }
    .sb-bar button { display: grid; background: none; border: 0; color: #fff; padding: 4px; cursor: pointer; }
    .sb-bar svg { width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 1.7; stroke-linecap: round; }
    .sb-bar a { color: #fff; text-decoration: none; font-size: 20px; }
    .sb-overlay { display: none; position: fixed; inset: 0; z-index: 40; background: rgba(0,0,0,.4); }
    .sb-overlay.on { display: block; }

    /* Desktop: sidebar always open, page sits to the right */
    @media (min-width: 768px) {
        body { padding-left: var(--sb-w); }
        .sb-bar, .sb-overlay, .sb-overlay.on { display: none; }
    }
    /* Mobile: sidebar slides in from the left */
    @media (max-width: 767px) {
        .sb { transform: translateX(-100%); }
        .sb.open { transform: none; }
        .sb-x { display: block; }
    }
    @media (prefers-reduced-motion: reduce) { .sb { transition: none; } }
</style>

<!-- Top bar (small screens only) - tap the menu button to open the sidebar -->
<div class="sb-bar">
    <button type="button" onclick="openMenu()" aria-label="Open menu" aria-controls="side-menu">
        <svg viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>

</div>
 <div class="px-4 py-1"></div>
<div id="menu-overlay" class="sb-overlay" onclick="closeMenu()"></div>

<div id="side-menu" class="sb sidemenu">

    <div class="sb-brand">
       <a href="/admin/dashboard" class="font-calligraphy">NAAP Library Archiving</a>
        <button type="button" class="sb-x" onclick="closeMenu()" aria-label="Close menu">&times;</button>
    </div>


    <nav class="sb-nav">

        <div class="sb-grp">MAIN</div>
        <a class="sb-link {{ request()->is('admin/dashboard') ? 'on' : '' }}" href="/admin/dashboard">
            <svg viewBox="0 0 24 24"><path d="M3 11l9-8 9 8v10H3z"/><path d="M9 21v-6h6v6"/></svg>Dashboard
        </a>

        <div class="sb-grp">RESEARCH</div>
        <a class="sb-link {{ request()->is('admin/dashboard/archive*') ? 'on' : '' }}" href="/admin/dashboard/archive">
            <svg viewBox="0 0 24 24"><path d="M3 6h7l2 2h9v11H3z"/></svg>Archive List
        </a>
        <a class="sb-link {{ request()->is('admin/dashboard/thesis/upload*') ? 'on' : '' }}" href="/admin/dashboard/thesis/upload">
            <svg viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>Upload
        </a>
        <a class="sb-link {{ request()->is('admin/dashboard/search*') ? 'on' : '' }}" href="/admin/dashboard/search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6"/><path d="M20 20l-4.5-4.5"/></svg>Search
        </a>

        <div class="sb-grp">MANAGEMENT</div>
        <a class="sb-link {{ request()->is('admin/dashboard/instructor*') ? 'on' : '' }}" href="/admin/dashboard/instructor/list">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c1-4.5 4-6 8-6s7 1.5 8 6"/></svg>Instructor List
        </a>
        <a class="sb-link {{ request()->is('admin/dashboard/borrow*') ? 'on' : '' }}" href="/admin/dashboard/borrow/list">
            <svg viewBox="0 0 24 24"><path d="M5 4h11a3 3 0 013 3v13H8a3 3 0 01-3-3z"/><path d="M9 8h6"/></svg>Borrowed List
        </a>
        <a class="sb-link {{ request()->is('admin/dashboard/logbook*') ? 'on' : '' }}" href="/admin/dashboard/logbook/list">
            <svg viewBox="0 0 24 24"><path d="M6 3h9l4 4v14H6z"/><path d="M14 3v5h5M9 13h7M9 17h7"/></svg>Log Book List
        </a>
        <a class="sb-link {{ request()->is('admin/dashboard/scan*') ? 'on' : '' }}" href="/admin/dashboard/scan">
            <svg viewBox="0 0 24 24"><path d="M4 8V5a1 1 0 011-1h3M16 4h3a1 1 0 011 1v3M20 16v3a1 1 0 01-1 1h-3M8 20H5a1 1 0 01-1-1v-3M4 12h16"/></svg>Scan List
        </a>
          <a class="sb-link {{ request()->is('admin/dashboard/calendar*') ? 'on' : '' }}" href="/admin/dashboard/calendar">
            <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>Calendar
        </a>

        <div class="sb-grp">SYSTEM</div>
        <a class="sb-link {{ request()->is('admin/dashboard/profile*') ? 'on' : '' }}" href="/admin/dashboard/profile/{{auth()->guard('admin')->user()->id}}">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.5 18.5c1.5-2.5 3.5-3.5 5.5-3.5s4 1 5.5 3.5"/></svg>My Profile
        </a>
        @if( auth()->guard('admin')->user()->id == 1 || auth()->guard('admin')->user()->id == 2)
        <a class="sb-link {{ request()->is('admin/dashboard/admin*') ? 'on' : '' }}" href="/admin/dashboard/admin">
            <svg viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/></svg>Admin List
        </a>
        @endif
        <!-- a class="sb-link" href="/admin/dashboard/student">Student List</a -->

        <form action="/admin/logout" method="POST" class="sb-out">
            @csrf
            <button type="submit" class="sb-link" onclick="return confirm('Are you sure want to logout?');">
                <svg viewBox="0 0 24 24"><path d="M9 4H5v16h4M16 8l4 4-4 4M20 12H9"/></svg>Logout
            </button>
        </form>

    </nav>
</div>


<!-- Javascript code -->
<script>
    var sideMenu = document.getElementById('side-menu');
    var menuOverlay = document.getElementById('menu-overlay');

    function openMenu() {
        sideMenu.classList.add('open');
        menuOverlay.classList.add('on');
    }

    function closeMenu() {
        sideMenu.classList.remove('open');
        menuOverlay.classList.remove('on');
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });
</script>
{{--
<div id="side-menu" class="fixed top-0 right-[-250px] w-[240px] h-screen z-50 bg-primary p-5 flex flex-col space-y-5 text-white duration-300 sidemenu">
    <div class="grid grid-cols-4 gap-4 ">
      <div class=" grid-rows-2 col-span-3">
          <div class="text-xl ">{{auth()->guard('admin')->user()->firstname}}</div>
          <div class="text-xs">{{auth()->guard('admin')->user()->email}}</div>
      </div>
      <div class=" "><a href="javascript:void(0)" class="text-right float-right text-3xl" onclick="closeMenu()">&times; </a></div>
    </div>
      <hr>
      <span class="text-xs font-semibold tracking-widest text-slate-400">MAIN</span>
      <a href="/admin/dashboard"class="hover:text-amber-500">Dashboard</a>
      <br><hr><br>
      <span class="text-[10px] font-semibold tracking-widest text-slate-400">RESEARCH</span>
      <a class="hover:text-amber-500" href="/admin/dashboard/archive">Archive List</a>
      <a class="hover:text-amber-500" href="/admin/dashboard/thesis/upload">Upload</a>
      <a class="hover:text-amber-500" href="/admin/dashboard/search">Search</a><br><hr>
      <span class="text-xs font-semibold tracking-widest text-slate-400">MANAGEMENT</span>
      <a class="hover:text-amber-500" href="/admin/dashboard/instructor/list">Instructor List</a>
      <a class="hover:text-amber-500" href="/admin/dashboard/borrow/list">Borrowed List</a>
      <a class="hover:text-amber-500" href="/admin/dashboard/logbook/list">Log Book List</a>
      <a class="hover:text-amber-500" href="/admin/dashboard/calendar">Calendar</a>
<<<<<<< Updated upstream
=======
      <a class="hover:text-amber-500" href="/admin/dashboard/scan">Scan List</a>
>>>>>>> Stashed changes
      <br><hr>
      <span class="text-xs font-semibold tracking-widest text-slate-400">SYSTEM</span>
      <a href="/admin/dashboard/profile/{{auth()->guard('admin')->user()->id}} "class="hover:text-amber-500">My Profile</a>
       @if( auth()->guard('admin')->user()->id == 1 || auth()->guard('admin')->user()->id == 2)
            <a class="hover:text-amber-500" href="/admin/dashboard/admin">
                Admin List
            </a>
        @endif
      <!-- a class="hover:text-amber-500" href="/admin/dashboard/student">Student List</a -->
      <br>
      <a class="hover:text-amber-500"><form action="/admin/logout" method="POST">
        @csrf
        <button class="text-l w-full text-left" onclick="return confirm('Are you sure want to logout?');">Logout</button>
    </form></a>
  </div>

  <main class="h-16 bg-primary  flex items-center justify-between">
      <!-- This is used to open the menu -->
      <span class="text-2xl pl-10 text-white font-calligraphy">
        <a href="/admin/dashboard">NAAP Library Archiving</a>
      </span>

      <span class="cursor-pointer text-2xl absolute right-0 mr-8 " onclick="openMenu()">
        @if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->photo)
        <div class="flex items-center gap-2 text-white">
            <img src="{{ asset('storage/' . auth()->guard('admin')->user()->photo) }}"
                class="rounded-full h-8 w-8 object-cover">
            <h1>{{ auth()->guard('admin')->user()->firstname }}</h1><i class="fas fa-bars"></i>
        </div>
        @else
          <h1>{{ auth()->guard('admin')->user()->firstname }}</h1>
        @endif

    </span>
  </main>
  <!-- Javascript code -->
  <script>
      var sideMenu = document.getElementById('side-menu');
      function openMenu() {
          sideMenu.classList.remove('right-[-250px]');
          sideMenu.classList.add('right-0');
      }

      function closeMenu() {
          sideMenu.classList.remove('right-0');
          sideMenu.classList.add('right-[-250px]');
      }
  </script>
- --}}
