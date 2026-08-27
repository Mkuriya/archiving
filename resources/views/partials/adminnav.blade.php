@include('partials.header') <div id="side-menu" class="fixed top-0 right-[-250px] w-[240px] h-screen z-50 bg-primary p-5 flex flex-col space-y-5 text-white duration-300">
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
