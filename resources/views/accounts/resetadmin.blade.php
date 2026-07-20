@include('partials.adminnav')
<div class="content ">
        <div class="grid grid-cols-12 gap-4 pt-4 mb-2"></div>
<section class="max-w-screen-xl p-6 mx-auto bg-indigo-600 rounded-md shadow-md dark:bg-gray-800 ">
    <h1 class="text-xl font-bold text-white capitalize dark:text-white">Reset Password</h1>
    <hr>
    @if (count($errors))
    <div class="flex items-center p-4 mb-4 text-sm text-red-800  rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
      <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
      </svg>
      <div>
        @foreach ($errors->all() as $error)
          <li class="font-medium list-none">{{$error}}</li> 
        @endforeach
      </div>
    </div>
  @endif
    <form action="/admin/dashboard/admin/reset" method="POST">
        @csrf
        <div class="bg-red-400 w-30">
          @if(session('status'))
            <div class="alert" role="alert">{{session('status')}}</div>    
          @elseif(session('error'))
            <div class="bg-sky-500" role="alert">{{session('error')}}</div>
          @endif
              
        </div>
        <div class="mt-4">
            <label class="text-white dark:text-gray-200 pl-2" for="lastname">Old Password</label>
            <input name="old_password" id="old_password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
        </div>
        <div class="mt-4">
            <label class="text-white dark:text-gray-200 pl-2" for="lastname">New Password</label>
            <input  name="new_password" id="new_password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
        </div>
        <div class="mt-4"> 
            <label class="text-white dark:text-gray-200 pl-2" for="lastname">Confirm Password</label>
            <input  name="confirm_password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
        </div>
        <div class="grid-row-2 col-span-10 mt-12">
            <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-12">   
                <div class="col-span-6">
                    <button type="submit"  class="block w-full px-4 py-2 mt-2 text-white bg-whitebg 
                        border border-gray-300 rounded-md hover:bg-gray-600">Change Password</button>
                </div>
                <div class="col-span-6">
                    <a href="/admin/dashboard/admin"><button type="button" class="block w-full px-4 py-2 mt-2 text-white bg-whitebg 
                        border border-gray-300 rounded-md hover:bg-gray-600">Back</button></a>
                </div>   
            </div> 
        </div> 

    </form>
</section>
</div>



@extends('partials.footer')
