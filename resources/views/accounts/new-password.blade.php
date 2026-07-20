@extends('partials.header')
<div class="login text-black flex min-h-screen flex-col items-center justify-center pt-16 sm:justify-center sm:pt-0 ">
    <div class="relative mt-12 w-full max-w-lg sm:mt-10">
        <div class="holder mx-5 border dark:border-b-white/50 dark:border-t-white/50 border-b-white/20 sm:border-t-white/20 shadow-[20px_0_20px_20px]
        shadow-slate-500/10 dark:shadow-white/20 rounded-lg border-white/20 border-l-white/20 border-r-white/20 sm:shadow-sm lg:rounded-xl 
        lg:shadow-none">
            <div class="flex flex-col p-6">
                <h3 class="text-3xl font-semibold leading-6 tracking-tighter text-center">Reset Password</h3>
            </div>
           
            <div class="p-6 pt-0 mt-4">
                <form action="{{ route('reset_password') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div>
                        
                    </div>
                    <div class="mt-4">
                        <div class="group relative rounded-lg border border-black focus-within:border-black px-3 pb-1.5 pt-2.5 duration-200 focus-within:ring focus-within:ring-black">
                            <div class="flex justify-between">
                                <label class="text-xs font-medium text-muted-foreground group-focus-within:text-black text-black">New Password</label>
                            </div>
                            <div class="flex items-center">
                                <input type="password" name="password" placeholder="Enter your password" class="block w-full border-0 bg-transparent p-0 text-sm placeholder:text-gray-800 focus:outline-none focus:ring-0 sm:leading-7">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="group relative rounded-lg border border-black focus-within:border-black px-3 pb-1.5 pt-2.5 duration-200 focus-within:ring focus-within:ring-black">
                            <div class="flex justify-between">
                                <label class="text-xs font-medium text-muted-foreground group-focus-within:text-black text-black">Confirm Password</label>
                            </div>
                            <div class="flex items-center">
                                <input type="password" name="password_confirmation" placeholder="Enter your password" class="block w-full border-0 bg-transparent p-0 text-sm placeholder:text-gray-800 focus:outline-none focus:ring-0 sm:leading-7">
                            </div>
                        </div>
                    </div>
                    <div class="my-2 flex items-center justify-center gap-x-2">
                        <button class="font-semibold hover:bg-gray-700 hover:text-white border-black transition duration-300 inline-flex items-center justify-center rounded-md text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-whitebg text-white h-10 px-4 py-2 w-48" type="submit">Reset Password</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>


@extends('partials.footer')