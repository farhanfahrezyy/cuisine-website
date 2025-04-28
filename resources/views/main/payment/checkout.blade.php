@extends('layouts.layoutpages')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Page Title -->
        <h1 class="text-2xl font-normal text-red-600 border-b-2 border-red-600 pb-2 mb-8">Checkout</h1>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left Column -->
            <div class="w-full lg:w-7/12">
                <!-- Resep Pesanan Section -->
                <div class="mb-10">
                    <h2 class="flex items-center text-lg font-medium mb-6">
                        <i class="fas fa-receipt mr-2"></i> Resep Pesanan
                    </h2>

                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                        {{-- @php
                            $defaultImage = 'default-recipe.jpg';
                            $imagePath = $recipe->image ?? $defaultImage;
                            $fullPath = storage_path('app/public/recipes/' . $imagePath);

                            // If the exact image doesn't exist, try to find a file with the recipe ID in the filename
                            if (!file_exists($fullPath) && isset($recipe->id)) {
                                $directoryFiles = glob(storage_path('app/public/recipes/*'));
                                foreach ($directoryFiles as $file) {
                                    $filename = basename($file);
                                    // Check if filename contains the recipe ID
                                    if (strpos($filename, $recipe->id) !== false) {
                                        $imagePath = $filename;
                                        break;
                                    }
                                }
                            }
                        @endphp --}}
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}"
                                class="uk-width-1-1" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>

                        <div class="mt-2">
                            <p class="font-medium text-gray-700">{{ $recipe->name }}</p>
                            <p class="font-bold text-gray-700 mt-1">Rp{{ number_format($recipe->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Resep Section -->
                <div>
                    <h2 class="flex items-center text-lg font-medium mb-6">
                        <i class="fas fa-info-circle mr-2"></i> Detail Resep
                    </h2>

                    <!-- Recipe description is not shown in the mockup, but kept in case it's needed -->
                    @if ($recipe->detail)
                        <p class="text-gray-600 mb-6">
                            {{ Str::limit($recipe->detail, 150) }}
                        </p>
                    @endif

                    <div class="grid grid-cols-2 gap-y-8">
                        <div>
                            <p class="text-gray-500 mb-1">Negara</p>
                            <p class="font-medium">{{ $recipe->country ?? '' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 mb-1">Rating</p>
                            <p class="font-medium">{{ $recipe->rating ?? '' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 mb-1">Kepedasan</p>
                            <p class="font-medium">{{ $recipe->spiciness ?? '' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 mb-1">Harga</p>
                            <p class="font-medium">Rp{{ number_format($recipe->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="w-full lg:w-5/12">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <!-- Rincian Belanja Header -->
                    <h2 class="text-lg font-medium mb-6">Rincian Belanja</h2>

                    <!-- Price Details -->
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Harga (1 Resep)</span>
                            <span>Rp{{ number_format($recipe->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Admin</span>
                            <span>Rp2.500</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">No. Rekening</span>
                            <span>178727186272 (BCA)</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <!-- Total -->
                    <div class="border-t border-gray-200 pt-4 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total Belanja</span>
                            @php
                                $recipePrice = $recipe->price ?? 14999;
                                $adminFee = 2500;
                                $totalPrice = $recipePrice + $adminFee;
                            @endphp
                            <span
                                class="font-bold text-xl text-red-600">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('payment.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="recipe_id" value="{{ $recipe->id ?? '' }}">

                        <!-- Upload Area -->
                        <div class="border border-dashed border-red-300 bg-red-50 rounded-lg p-8 mb-6 text-center">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>

                            <p class="text-red-500 font-medium mb-2" id="file-name">Belum ada berkas dipilih</p>
                            <p class="text-gray-500 text-sm mb-4">
                                Maksimal ukuran file: 20MB.<br>
                                Ukuran yang disarankan: 1080x1080 px.
                            </p>

                            <label for="payment_proof"
                                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded cursor-pointer inline-block">
                                Pilih Berkas
                            </label>
                            <input type="file" id="payment_proof" name="payment_proof" class="hidden" required
                                onchange="updateFileName(this)">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded font-medium">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameElement = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameElement.textContent = input.files[0].name;
                fileNameElement.classList.remove('text-red-500');
                fileNameElement.classList.add('text-green-500');
            } else {
                fileNameElement.textContent = 'Belum ada berkas dipilih!';
                fileNameElement.classList.remove('text-green-500');
                fileNameElement.classList.add('text-red-500');
            }
        }
    </script>
@endsection
