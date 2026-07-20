
@include('partials.adminnav')
<div class="sm:mt-6 mt-0">
        <section class="max-w-screen-xl p-6 mx-auto rounded-md shadow-md bg-gray-800">
            <h1 class="text-xl font-bold text-white capitalize">Admin Information</h1>
            <hr>
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                <div class="sm:col-span-2">
                    <div>
                        <label class="text-gray-200 pl-2" for="lastname">Last Name</label>
                        <input value="{{$admin->lastname}}" disabled name="lastname" id="username" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                    <div class="mt-2">
                        <label class="text-gray-200 pl-2" for="firstname">First Name</label>
                        <input value="{{$admin->firstname}}" disabled name="firstname" id="username" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                    <div class="mt-2">
                        <label class="text-gray-200 pl-2" for="middlename">Middle Name</label>
                        <input value="{{$admin->middlename}}" disabled name="middlename" id="username" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                    <div class="mt-2">
                        <label class="text-gray-200 pl-2" for="gender">Gender</label>
                        <input value="{{$admin->gender}}" disabled name="gender" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                    </div> 
                    <div class="mt-2">
                        <label class="text-gray-200 pl-2" for="email">Email</label>
                        <input value="{{$admin->email}}" disabled name="email" id="password" type="email" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-500 focus:outline-none focus:ring">
                    </div> 
                </div>
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium  text-white">Image</label>
                    <div class="relative flex items-center justify-center w-full h-96 sm:w-96 sm:h-96 rounded-md border border-gray-600 text-center">
                        <img class="object-cover  w-full h-full rounded-md" src="{{ asset('storage/' . $admin->photo) }}"/>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <a href="/admin/dashboard/admin" class="w-full sm:w-auto">
                    <button class="w-full sm:w-auto mr-4 px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-whitebg rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Back</button>
                </a>
            </div>
        </section>
</div>

@extends('partials.footer')
