@extends('layouts.layoutpages')

@section('title', 'About Us')

@section('content')
<div class="container mx-auto px-4 md:px-8 lg:px-16 py-8">
    <!-- Hero Section -->
    <div class="max-w-4xl mx-auto text-center mb-16">
        <h1 class="text-3xl md:text-4xl font-bold mb-6">About Cuisine</h1>
        <p class="text-lg text-gray-600">
            Discovering and sharing the best recipes and culinary experiences from around the world.
        </p>
    </div>

    <div class="max-w-4xl mx-auto mb-16">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h2 class="text-2xl font-bold mb-4">Our Story</h2>
                <p class="text-gray-600 mb-4">
                    Founded in 2020, Cuisine started with a simple mission: to make cooking more accessible
                    and enjoyable for everyone. What began as a small collection of family recipes has grown
                    into a vibrant community of food lovers sharing their culinary adventures.
                </p>
                <p class="text-gray-600">
                    Today, we're proud to be one of the fastest-growing recipe platforms, helping millions
                    of home cooks discover new flavors and techniques every day.
                </p>
            </div>
            <div>
                <img
                    src="{{ asset('images/ayam_goreng.jpg') }}"
                    alt="Our story"
                    class="rounded-lg w-full h-[300px] object-cover"
                >
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16 -mx-4 md:-mx-8 lg:-mx-16 mb-16">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-8 text-center">Our Mission</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Inspire</h3>
                        <p class="text-gray-600">Inspiring home cooks to explore new cuisines and cooking techniques.</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Connect</h3>
                        <p class="text-gray-600">Building a community of passionate food lovers and home chefs.</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Educate</h3>
                        <p class="text-gray-600">Sharing culinary knowledge and traditions from around the world.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <!-- Join Us Section -->
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-2xl font-bold mb-4">Join Our Community</h2>
        <p class="text-gray-600 mb-8">
            Be part of our growing community of food lovers. Share recipes, discover new cuisines,
            and connect with fellow cooking enthusiasts.
        </p>
        <a href="#" class="inline-block bg-red-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-600 transition-colors">
            Sign Up Now
        </a>
    </div> --}}
</div>
@endsection
