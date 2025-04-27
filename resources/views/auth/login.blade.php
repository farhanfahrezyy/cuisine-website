@extends('layouts.auth')
@section('title', 'Login')
@section('main')

<section class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <!-- Right Section: Login Form -->
    <div class="w-full lg:max-w-md p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <!-- Alert for session errors -->
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
            <div class="mt-2">Sign in</div>
        </h2>
        <form class="mt-8 space-y-6" action="{{ route('user.login.submit') }}" method="POST">
            @csrf
            <!-- Email Field -->
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#eb4a36] focus:border-[#eb4a36] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#eb4a36] dark:focus:border-[#eb4a36] @error('email') border-red-500 @enderror"
                    placeholder="name@company.com" required />
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                <input type="password" name="password" id="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#eb4a36] focus:border-[#eb4a36] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#eb4a36] dark:focus:border-[#eb4a36] @error('password') border-red-500 @enderror"
                    placeholder="••••••••" required />
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-[#eb4a36] dark:focus:ring-[#eb4a36] dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                    <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
                {{-- <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#eb4a36] hover:underline dark:text-[#eb4a36]" aria-label="Forgot password?">Lost Password?</a> --}}
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-[#eb4a36] rounded-lg hover:bg-[#d13c2e] focus:ring-4 focus:ring-[#eb4a36] dark:bg-[#eb4a36] dark:hover:bg-[#d13c2e] dark:focus:ring-[#eb4a36]">
                Login to your account
            </button>

            <!-- Register Link -->
            <div class="text-sm font-medium text-gray-900 dark:text-white text-center">
                Not registered yet? <a href="{{ route('user.register.form') }}" class="text-[#eb4a36] hover:underline dark:text-[#eb4a36]" aria-label="Create an account">Create account</a>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<!-- You can add any custom scripts here if needed -->
@endpush
