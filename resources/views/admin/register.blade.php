@include('partials.adminnav')
<div class="sm:mt-6 mt-0">
    <section class="max-w-screen-xl p-6 mx-auto rounded-md shadow-md bg-gray-800 ">
        <h1 class="text-xl font-bold text-white capitalize">Register Admin</h1>
        <hr>
        <form action="/admin/register" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-12">   
                
                    <div class="sm:col-span-5 col-span-5">
                        <label class="text-gray-200 pl-2" for="lastname">Last Name</label>
                        <input name="lastname" value="{{ old('lastname') }}" id="username" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                        <span class="text-red-600"> @error('lastname'){{$message}}@enderror</span>
                    </div>
                    <div class="sm:col-span-5 col-span-5">
                        <label class="text-gray-200 pl-2" for="firstname">First Name</label>
                        <input name="firstname" value="{{ old('firstname') }}" id="username" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                        <span class="text-red-600"> @error('firstname'){{$message}}@enderror</span>
                    </div>
                    <div class="sm:col-span-2 col-span-5">
                        <label class="text-gray-200" for="middlename">Middle Name</label>
                        <input name="middlename" value="{{ old('middlename') }}" id="username" type="text" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                        <span class="text-red-600"> @error('middlename'){{$message}}@enderror</span>
                    </div>
            </div>
            <div class="grid grid-cols-5 gap-6 mt-4 sm:grid-cols-12">
                <div class="sm:col-span-10 col-span-10">
                    <label class="text-gray-200" for="email">Email</label>
                    <input name="email" value="{{ old('email') }}" id="password" type="email" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                    <span class="text-red-600"> @error('email'){{$message}}@enderror</span>
                </div> 
                
                <div class="sm:col-span-2 col-span-10">
                    <label class="text-gray-200" for="gender">Gender</label>
                    
                    <select name="gender" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                        <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select><span class="text-red-600">@error('gender'){{$message}}@enderror</span>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-12">
                <div class="sm:col-span-10 col-span-1">
                    <div>
                        <label class="text-gray-200" for="password">Password</label>
                        <input name="password" id="password" type="password" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                        <span class="text-red-600">@error('password'){{$message}}@enderror</span>
                    </div>
                    <br>
                    <div>
                        <label class="text-gray-200" for="passwordConfirmation">Password Confirmation</label>
                        <input name="password_confirmation" id="passwordConfirmation" type="password" class="block w-full px-4 py-2 mt-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white ">
                        <span class="text-red-600">@error('password'){{$message}}@enderror</span>
                    </div>
                </div>
                <div class="sm:col-span-2 col-span-1">
                    <div class="flex items-center space-x-2">
                        <label class="block text-sm font-medium text-white"> Image </label>
                        <p class="text-xs text-gray-400">Image must be 2x2 size.</p>
                    </div>
                    <div>
                        <label class="block hover:bg-gray-700">
                            <input type="file" name="photo" onchange="previewImage(event)" class="mt-2 w-42 flex justify-center px-2 py-2 border border-gray-600 rounded-md block w-full text-sm text-white file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-transparent file:text-white hover:file:bg-gray-700"/>
                        </label>
                        <span class="text-red-600">@error('photo'){{$message}}@enderror</span>
                        <label for="file" class="mt-2 relative flex min-h-[150px] bg-gray-700 items-center justify-center rounded-md border border-gray-600 text-center">
                            <img id="imagePreview" class="h-48 sm:h-44 w-56 object-cover" src="/img/profile.jpg" alt="Current profile photo" />
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="w-1/2 sm:w-20  px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-whitebg rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Save</button>
                
                <a href="/admin/dashboard/admin"class="sm:w-20 ml-4 w-1/2 px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-whitebg rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600 text-center">
                    <button type="button" >Back</button>
                </a>
            </div>
        </form>
    </section>
</div>
<div class="fixed bottom-4 right-4 z-50 w-96">
    @if(session('success'))
        <div class="bg-gray-200 p-4 rounded relative alert" role="alert">
            {{ session('success') }}
            <button type="button" class="absolute top-0 right-0 mt-2 mr-4 text-lg text-gray-600 hover:text-gray-800" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @elseif(session('error'))
        <div class="bg-sky-500 p-4 rounded relative alert" role="alert">
            {{ session('error') }}
            <button type="button" class="absolute top-0 right-0 mt-2 mr-4 text-lg text-gray-600 hover:text-gray-800" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif
</div>

@extends('partials.footer')