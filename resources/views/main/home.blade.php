@extends('layouts.layoutpages')

@section('title', 'User Preferences')

@push('style')
    <style>
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            width: 48px;
            height: 48px;
            border: 5px solid #FFF;
            border-bottom-color: #FF3D00;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .option-card {
            transition: all 0.2s ease-in-out;
        }

        .option-card:hover {
            transform: scale(1.02);
        }
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        @if (!auth()->check())
            <script>
                window.location.href = "{{ route('user.login.form') }}";
            </script>
        @elseif(auth()->user()->has_submitted_preferences)
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6" role="alert">
                <p class="font-medium text-center">Anda sudah mengisi form preferensi makanan sebelumnya.</p>
                <p class="text-center mt-2">Preferensi anda telah tersimpan dalam sistem kami.</p>
                <div class="flex justify-center mt-4">
                    <a href="{{ route('home') }}"
                        class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
            <div class="loader-container" id="loaderContainer">
                <span class="loader"></span>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('user.preferences.store') }}" id="preferenceForm" method="POST">
                @csrf

                <!-- Country Category -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-600 mb-4">Negara (Pilih maksimum 3)</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="country-group">
                        @foreach (['india' => 'India', 'italia' => 'Italia', 'jepang' => 'Jepang', 'korea' => 'Korea', 'indonesia' => 'Indonesia', 'western' => 'Western'] as $value => $label)
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden peer-checked:border-red-500 peer-checked:border-4 peer-checked:bg-red-500/20">
                                <input type="checkbox" name="country[]" value="{{ $value }}" class="hidden peer">
                                <img src="{{ asset('images/' . $value . '.png') }}" alt="{{ $label }}"
                                    class="w-full h-full object-cover rounded-lg">
                                <span class="absolute bottom-2 right-2 bg-white px-2 py-1 rounded text-sm font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('country')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Primary Ingredient Category -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-600 mb-4">Bahan Utama (Pilih maksimum 3)</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="primary-ingredient-group">
                        @foreach (['nasi' => 'Nasi', 'kentang' => 'Kentang', 'mie' => 'Mie', 'tepung' => 'Tepung', 'roti' => 'Roti', 'pasta' => 'Pasta'] as $value => $label)
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden peer-checked:border-red-500 peer-checked:border-4 peer-checked:bg-red-500/20">
                                <input type="checkbox" name="primary_ingredient[]" value="{{ $value }}" class="hidden peer">
                                <img src="{{ asset('images/' . ($value === 'kentang' ? 'potato' : ($value === 'roti' ? 'bread' : $value)) . '.png') }}" alt="{{ $label }}"
                                    class="w-full h-full object-cover rounded-lg">
                                <span class="absolute bottom-2 right-2 bg-white px-2 py-1 rounded text-sm font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('primary_ingredient')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Secondary Ingredient Category -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-600 mb-4">Bahan Sekunder (Pilih maksimum 3)</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="secondary-ingredient-group">
                        @foreach ([
                            'daging_ayam' => 'Daging Ayam',
                            'daging_sapi' => 'Daging Sapi',
                            'daging_kambing' => 'Daging Kambing',
                            'telur_ayam' => 'Telur Ayam',
                            'udang' => 'Udang',
                            'fish' => 'ikan',
                            'tahu' => 'Tahu',
                            'jamur' => 'Jamur',
                            'sayuran' => 'Sayuran'
                        ] as $value => $label)
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden peer-checked:border-red-500 peer-checked:border-4 peer-checked:bg-red-500/20">
                                <input type="checkbox" name="secondary_ingredient[]" value="{{ $value }}" class="hidden peer">
                                <img src="{{ asset('images/' . ($value === 'daging_ayam' ? 'ayam' : ($value === 'daging_sapi' ? 'sapi' : ($value === 'daging_kambing' ? 'kambing' : ($value === 'telur_ayam' ? 'egg' : ($value === 'sayuran' ? 'sayur' : $value))))) . '.png') }}" alt="{{ $label }}"
                                    class="w-full h-full object-cover rounded-lg">
                                <span class="absolute bottom-2 right-2 bg-white px-2 py-1 rounded text-sm font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('secondary_ingredient')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Spiciness Category -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-600 mb-4">Pedas (Pilih satu saja)</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="spiciness-group">
                        @foreach (['ringan' => 'Ringan', 'sedang' => 'Sedang', 'pedas' => 'Pedas'] as $value => $label)
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden peer-checked:border-red-500 peer-checked:border-4 peer-checked:bg-red-500/20">
                                <input type="radio" name="spiciness" value="{{ $value }}" class="hidden peer" required>
                                <img src="{{ asset('images/' . $value . '.png') }}" alt="{{ $label }}"
                                    class="w-full h-full object-cover rounded-lg">
                                <span class="absolute bottom-2 right-2 bg-white px-2 py-1 rounded text-sm font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('spiciness')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center mb-12">
                    <button type="submit"
                        class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition disabled:bg-gray-400 disabled:cursor-not-allowed"
                        id="submitButton">
                        Submit
                    </button>
                </div>
            </form>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('preferenceForm');
            const loaderContainer = document.getElementById('loaderContainer');
            const submitButton = document.getElementById('submitButton');

            // Limit checkbox selections
            function limitCheckboxes(groupId, max) {
                const checkboxes = document.querySelectorAll(`#${groupId} input[type="checkbox"]`);
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                        if (checkedCount > max) {
                            checkbox.checked = false;
                            alert(`Maksimum ${max} pilihan diperbolehkan untuk ${groupId.replace(/-/g, ' ')}`);
                        }
                    });
                });
            }

            // Initialize checkbox limits
            limitCheckboxes('country-group', 3);
            limitCheckboxes('primary-ingredient-group', 3);
            limitCheckboxes('secondary-ingredient-group', 3);

            // Form submission
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Client-side validation
                const countryChecked = document.querySelectorAll('#country-group input[type="checkbox"]:checked').length;
                const primaryIngredientChecked = document.querySelectorAll('#primary-ingredient-group input[type="checkbox"]:checked').length;
                const secondaryIngredientChecked = document.querySelectorAll('#secondary-ingredient-group input[type="checkbox"]:checked').length;
                const spicinessChecked = document.querySelector('input[name="spiciness"]:checked');

                if (countryChecked === 0 || countryChecked > 3) {
                    alert('Silakan pilih 1-3 negara');
                    return;
                }
                if (primaryIngredientChecked === 0 || primaryIngredientChecked > 3) {
                    alert('Silakan pilih 1-3 bahan utama');
                    return;
                }
                if (secondaryIngredientChecked === 0 || secondaryIngredientChecked > 3) {
                    alert('Silakan pilih 1-3 bahan sekunder');
                    return;
                }
                if (!spicinessChecked) {
                    alert('Silakan pilih tingkat kepedasan');
                    return;
                }

                try {
                    // Show loader
                    loaderContainer.style.display = 'flex';
                    submitButton.disabled = true;

                    // Submit form
                    form.submit();
                } catch (error) {
                    console.error('Form submission error:', error);
                    loaderContainer.style.display = 'none';
                    submitButton.disabled = false;
                    alert('Terjadi kesalahan saat mengirimkan form. Silakan coba lagi.');
                }
            });

            // Visual feedback for selections
            document.querySelectorAll('input[type="checkbox"].peer, input[type="radio"].peer').forEach(input => {
                input.addEventListener('change', () => {
                    const parent = input.closest('label');
                    if (input.checked) {
                        parent.classList.add('border-red-500', 'border-4', 'bg-red-500/20');
                        parent.classList.remove('border-gray-300', 'border-2', 'bg-gray-100');
                    } else {
                        parent.classList.remove('border-red-500', 'border-4', 'bg-red-500/20');
                        parent.classList.add('border-gray-300', 'border-2', 'bg-gray-100');
                    }
                });
            });
        });
    </script>
@endsection
