@extends('layouts.auth')

@section('title', 'Register')

@section('main')
    <section class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
        <!-- Right Section: Register Form -->
        <div class="w-full lg:max-w-md p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <!-- Alert for any errors -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Alert for success messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">
                <a class="uk-navbar-item uk-logo text" href="{{ route('home') }}">Cuisiné</a>
                <div class="mt-2">Sign Up</div>
            </h2>
            <form class="space-y-6" action="{{ route('user.register.submit') }}" method="POST">
                @csrf

                <!-- Email Field -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" id="floating_email" value="{{ old('email') }}"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-[#eb4a36] focus:outline-none focus:ring-0 focus:border-[#eb4a36] peer @error('email') border-red-500 @enderror"
                        placeholder=" " required />
                    <label for="floating_email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#eb4a36] peer-focus:dark:text-[#eb4a36] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                        address</label>

                    @error('email')
                        <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password" id="floating_password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-[#eb4a36] focus:outline-none focus:ring-0 focus:border-[#eb4a36] peer @error('password') border-red-500 @enderror"
                        placeholder=" " required />
                    <label for="floating_password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#eb4a36] peer-focus:dark:text-[#eb4a36] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                    @error('password')
                        <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password_confirmation" id="floating_repeat_password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-[#eb4a36] focus:outline-none focus:ring-0 focus:border-[#eb4a36] peer @error('password_confirmation') border-red-500 @enderror"
                        placeholder=" " required />
                    <label for="floating_repeat_password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#eb4a36] peer-focus:dark:text-[#eb4a36] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm
                        password</label>
                    @error('password_confirmation')
                        <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- First Name Field -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="first_name" id="floating_first_name" value="{{ old('first_name') }}"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-[#eb4a36] focus:outline-none focus:ring-0 focus:border-[#eb4a36] peer @error('first_name') border-red-500 @enderror"
                        placeholder=" " required />
                    <label for="floating_first_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#eb4a36] peer-focus:dark:text-[#eb4a36] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                        name</label>

                    @error('first_name')
                        <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Name Field -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="last_name" id="floating_last_name" value="{{ old('last_name') }}"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-[#eb4a36] focus:outline-none focus:ring-0 focus:border-[#eb4a36] peer @error('last_name') border-red-500 @enderror"
                        placeholder=" " required />
                    <label for="floating_last_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-[#eb4a36] peer-focus:dark:text-[#eb4a36] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                        name</label>
                    @error('last_name')
                        <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full px-5 py-3 text-base font-medium text-center text-white bg-[#eb4a36] rounded-lg hover:bg-[#d13c2e] focus:ring-4 focus:ring-[#eb4a36] dark:bg-[#eb4a36] dark:hover:bg-[#d13c2e] dark:focus:ring-[#eb4a36]">
                    Create Account
                </button>

                <!-- Login Link -->
                <div class="text-sm font-medium text-gray-900 dark:text-white text-center">
                    Already have an account? <a href="{{ route('user.login.form') }}" class="text-[#eb4a36] hover:underline dark:text-[#eb4a36]">Sign in</a>
                </div>
            </form>
        </div>
    </section>
@endsection
