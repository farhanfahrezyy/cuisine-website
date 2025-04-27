@extends('layouts.auth')
@section('title', 'Login')
@section('main')

<section class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <!-- Right Section: Login Form -->
    <div class="w-full lg:max-w-md p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">

        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">
            <a class="uk-navbar-item uk-logo text" href="index.html">Cuisiné</a>
            Sign in <button class="text-[#eb4a36] hover:underline dark:text-[#eb4a36]">Admin</button>
        </h2>
        <form class="mt-8 space-y-6" action="{{ route('admin.submit.login') }}" method="POST">
            @csrf
            <!-- Email Field -->
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#eb4a36] focus:border-[#eb4a36] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#eb4a36] dark:focus:border-[#eb4a36]" placeholder="name@company.com" form-control @error('email') is-invalid @enderror required />
                @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#eb4a36] focus:border-[#eb4a36] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#eb4a36] dark:focus:border-[#eb4a36]" form-control @error('password') is-invalid @enderror required />
                @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-[#eb4a36] dark:focus:ring-[#eb4a36] dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" />
                    <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
                <a href="#" class="text-sm font-medium text-[#eb4a36] hover:underline dark:text-[#eb4a36]" aria-label="Forgot password?">Lost Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-[#eb4a36] rounded-lg hover:bg-[#d13c2e] focus:ring-4 focus:ring-[#eb4a36] dark:bg-[#eb4a36] dark:hover:bg-[#d13c2e] dark:focus:ring-[#eb4a36]">
                Login to your account
            </button>

            <!-- Register Link -->
            <div class="text-sm font-medium text-gray-900 dark:text-white text-center">
                Not registered yet? <a href="" class="text-[#eb4a36] hover:underline dark:text-[#eb4a36]" aria-label="Create an account">Create account</a>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')

@endpush
