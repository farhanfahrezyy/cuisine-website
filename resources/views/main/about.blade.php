@extends('layouts.layoutpages')

@section('title', 'Tentang Kami')

@section('content')
<div class="container mx-auto px-4 md:px-8 lg:px-16 py-12">
    <!-- Hero Section -->
    <div class="max-w-4xl mx-auto text-center mb-16">
        <h1 class="text-3xl md:text-4xl font-bold mb-6 text-gray-800">Tentang <span class="text-red-500">Cuisine</span></h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
            Tempat menemukan inspirasi masakan sehari-hari dengan resep praktis dan bahan mudah ditemukan.
        </p>
    </div>

    <!-- Story Section -->
    <div class="max-w-5xl mx-auto mb-20 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="md:flex">
            <div class="md:flex-1 p-8 md:p-12">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Cerita Kami</h2>
                <div class="space-y-4 text-gray-600">
                    <p>
                        Cuisine hadir sebagai solusi untuk Anda yang sering bingung menentukan menu masakan sehari-hari. Kami menyajikan resep-resep terbaik yang telah diuji coba dengan takaran pas dan langkah jelas.
                    </p>
                    <p>
                        Mulai dari sarapan sederhana hingga makan malam spesial, semua bisa Anda temukan dengan mudah di sini.
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-red-500 font-medium hover:text-red-600 transition-colors">
                            Jelajahi Resep Kami
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="md:flex-1">
                <img class="h-full w-full object-cover" src="{{ asset('images/masakan_rumahan.jpg') }}" alt="Proses Memasak">
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-5xl mx-auto mb-20">
        <h2 class="text-2xl font-bold mb-12 text-center text-gray-800">Kenapa Memilih Cuisine?</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-14 h-14 bg-red-50 rounded-lg flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Resep Terpercaya</h3>
                <p class="text-gray-600">
                    Setiap resep telah kami uji coba untuk memastikan hasil yang konsisten dan lezat.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-14 h-14 bg-red-50 rounded-lg flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Panduan Visual</h3>
                <p class="text-gray-600">
                    Langkah-langkah dilengkapi foto sehingga mudah diikuti bahkan oleh pemula.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-14 h-14 bg-red-50 rounded-lg flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Bahan Mudah</h3>
                <p class="text-gray-600">
                    Menggunakan bahan-bahan yang mudah ditemukan di pasar atau supermarket terdekat.
                </p>
            </div>
        </div>
    </div>
 @auth

 @endauth
    <!-- CTA Section -->
    @guest
<div class="max-w-3xl mx-auto bg-gradient-to-r from-red-500 to-orange-500 rounded-2xl p-10 text-center text-white">
    <h2 class="text-2xl font-bold mb-4">Mulai Petualangan Masak Anda</h2>
    <p class="mb-6 opacity-90">
        Bergabunglah dengan komunitas kami dan dapatkan akses ke ratusan resep lezat setiap minggunya.
    </p>
    <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{ route('user.register.form') }}" class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors shadow-md">
            Daftar Sekarang
        </a>
        <a href="{{ route('home') }}" class="border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:bg-opacity-10 transition-colors">
            Lihat Resep
        </a>
    </div>
</div>
@endguest
</div>
@endsection
