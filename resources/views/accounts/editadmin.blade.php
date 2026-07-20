@include('partials.adminnav')
<div class="sm:mt-6 mt-0 ">
<section class="max-w-screen-xl p-6 mx-auto rounded-md shadow-md bg-gray-800 ">
    <h1 class="text-xl font-bold text-white capitalize">Update Admin</h1>
    <hr>
    <form action="/admin/dashboard/admin/edit/{{$admin->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-12">   
            <div class="sm:col-span-5 col-span-12">
                <label class="text-gray-200 pl-2" for="lastname">Last Name</label>
                <input value="{{$admin->lastname}}" name="lastname" id="lastname" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
            </div>
            <div class="sm:col-span-5 col-span-12 ">
                <label class="text-gray-200 pl-2" for="firstname">First Name</label>
                <input value="{{$admin->firstname}}" name="firstname" id="firstname" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
            </div>
            <div class="sm:col-span-2 col-span-12">
                <label class="text-gray-200" for="middlename">Middle Name</label>
                <input value="{{$admin->middlename}}" name="middlename" id="middlename" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
            </div>
        </div>
        <div class="grid grid-cols-5 gap-6 mt-4 sm:grid-cols-12">
            <div class="sm:col-span-10 col-span-12">
                <label class="text-gray-200" for="email">Email</label>
                <input value="{{$admin->email}}" disabled name="email" id="email" type="email" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                <span class="block mt-2 text-sm text-gray-500 dark:text-gray-400">This email cannot be edited</span>
            </div>
             
            
            <div class="sm:col-span-2 col-span-12">
                <label class="text-gray-200" for="gender">Gender</label>
                <select name="gender" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                    <option value="Female" {{$admin->gender == 'Female' ? 'selected' : ''}}>Female</option>
                    <option value="Male" {{$admin->gender == 'Male' ? 'selected' : ''}}>Male</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-6 mt-4 sm:grid-cols-12">
            <div class="grid-row-2 sm:col-span-10 col-span-12">
                <div>
                    <label class="text-gray-200" for="password">Password</label>
                    <input name="password" id="password" type="password" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white  ">
                    <span class="text-red-400">@error('password'){{$message}}@enderror</span>
                </div>
                <br>
                <div>
                    <label class="text-gray-200" for="password_confirmation">Password Confirmation</label>
                    <input name="password_confirmation" id="password_confirmation" type="password" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white  ">
                    <span class="text-red-400">@error('password'){{$message}}@enderror</span>
                </div>
            </div>
            <div class="sm:col-span-2 col-span-12">
                <div class="flex items-center space-x-2">
                    <label class="block text-sm font-medium text-white"> Image </label>
                    <p class="text-xs text-gray-400">Image must be 2x2 size.</p>
                </div>
                <div>
                    <input type="file" name="photo" id="file" class="sr-only mt-1 flex justify-center px-4 pt-3 pb-4 border-2 border-gray-600 rounded-md" onchange="previewImage(event)" />
                    <label for="file" class="relative flex items-center justify-center rounded-md border bg-gray-700 border-gray-600 text-center">
                        <div id="imagePreviewContainer" class="sm:h-48 sm:w-48 h-80 w-80 "> <!-- Adjust height and width as per requirement -->
                            <img id="imagePreview" src="{{asset('storage/' . $admin->photo) }}" class=" object-cover h-full w-full" />
                        </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-6">
            <button type="submit" class="sm:w-20 w-full py-2 leading-5 text-white transition-colors duration-200 transform bg-whitebg rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Update</button>
            <a href="/admin/dashboard/admin" class=" ml-4 w-full sm:w-20 px-6 py-2 leading-5 text-white text-center transition-colors duration-200 transform bg-whitebg rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600"><button type="button" >Back</button></a>
        </div>
    </form>
    
   
</section>
</div>
<script src="/js/previewimage.js"></script>
@extends('partials.footer')
