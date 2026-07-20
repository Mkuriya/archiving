@include('partials.adminnav')
@if ($errors->has('old_password') || $errors->has('new_password') || $errors->has('confirm_password'))
    <!-- Modal overlay -->
    <div id="errorModalOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
        <!-- Modal structure -->
        <div class="bg-gray-300 rounded-lg shadow-lg w-11/12 md:w-1/3">
            <div class="flex justify-between items-center bg-red-500 text-white text-xl p-4 rounded-t-lg">
                <svg height="32" style="overflow:visible;enable-background:new 0 0 32 32" viewBox="0 0 32 32" width="32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g>
                        <g id="Error_1_">
                            <g id="Error">
                                <circle cx="16" cy="16" id="BG" r="16" style="fill:#D72828;"/>
                                <path d="M14.5,25h3v-3h-3V25z M14.5,6v13h3V6H14.5z" id="Exclamatory_x5F_Sign" style="fill:#E6E6E6;"/>
                            </g>
                        </g>
                    </g>
                </svg>
                <h5 class="font-bold">There are some errors, please correct them.</h5>
                <button id="closeErrorModal" class="text-2xl leading-none">&times;</button>
            </div>
            <div class="p-4">
                <div class="text-red-800 text-start pl-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="flex justify-center p-4">
                <button id="closeErrorModalBtn" class="bg-whitebg text-white px-16 py-1 rounded-full hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
@endif
<div class="sm:mt-6 mt-0 ">
    <section class="max-w-screen-xl p-6 mx-auto rounded-md shadow-md bg-gray-800 ">
        <h1 class="text-xl font-bold text-white capitalize ">Change Password</h1>
        <hr>
        
        <form action="/admin/dashboard/profile/changepassword/update" method="POST">
            @csrf
            <div class="mt-4">
                <label class="text-gray-200 pl-2" for="old_password">Old Password</label>
                <input name="old_password" id="old_password" type="password" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
            </div>
            <div class="mt-4">
                <label class="text-gray-200 pl-2" for="new_password">New Password</label>
                <input  name="new_password" id="new_password" type="password" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
            </div>
            <div class="mt-4"> 
                <label class="text-gray-200 pl-2" for="confirm_password">Confirm Password</label>
                <input  name="confirm_password" type="password" class="block w-full px-4 py-2 mt-2  border  rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
            </div>
            <div class="grid-row-2 col-span-10 mt-12">
                <div class="grid grid-cols-2 gap-6 mt-2 sm:mt-8">
                    <div class="col-span-1">
                        <button type="submit" class="block w-full px-4 py-2 mt-2 text-white bg-whitebg border border-gray-300 rounded-md hover:bg-gray-600">Change Password</button>
                    </div>
                    <div class="col-span-1">
                        <a href="/admin/dashboard/profile/{{auth()->guard('admin')->user()->id}}">
                            <button type="button" class="block w-full px-4 py-2 mt-2 text-white bg-whitebg border border-gray-300 rounded-md hover:bg-gray-600">Back</button>
                        </a>
                    </div>
                </div>
            </div> 

        </form>
    </section>
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-gray-400 p-6 rounded-lg shadow-lg">
        <h3 class="text-xl item-center font-semibold mb-4 border-b-2 border-black">{{ session('status') }}</h3>
        <a href="/admin/dashboard/profile/{{auth()->guard('admin')->user()->id}}"><button id="closeModal" class="w-full px-4 py-2 bg-whitebg text-white rounded-md hover:bg-gray-700">Close</button></a>
    </div>
    </div>

    <!-- Hidden Button to Trigger Modal -->
    <button id="successButton" class="hidden" type="button" onclick="document.getElementById('successModal').classList.remove('hidden')"></button>

</div>

<script>
  document.addEventListener("DOMContentLoaded", function(event) {
      @if(session('status'))
          document.getElementById('successButton').click();
      @endif
  
      document.getElementById('closeModal').addEventListener('click', function() {
          document.getElementById('successModal').classList.add('hidden');
      });
  });
  </script>


<script src="/js/modal.js"></script>

@extends('partials.footer')
