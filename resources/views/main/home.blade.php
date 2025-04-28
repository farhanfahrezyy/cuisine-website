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

                <!-- Hidden field for spiciness (will be populated by JavaScript) -->
                <input type="hidden" name="spiciness" id="spicinessValue">

                <!-- Country Category -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-600 mb-4">Negara (Pilih maksimum 3)</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="country-group">
                        @foreach (['india' => 'India', 'italia' => 'Italia', 'jepang' => 'Jepang', 'korea' => 'Korea', 'indonesia' => 'Indonesia', 'western' => 'Western'] as $value => $label)
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden">
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
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden">
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
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden">
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
                            <label class="option-card relative flex items-center w-64 h-40 bg-gray-100 rounded-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-200 overflow-hidden">
                                <input type="checkbox" name="spiciness_checkbox" value="{{ $value }}" class="hidden peer spiciness-checkbox">
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

    <!-- Modal Alert -->
    <div id="alertModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
            <div class="text-center">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2" id="modalTitle"></h3>
                <p class="text-sm text-gray-500" id="modalMessage"></p>
                <div class="mt-4">
                    <button type="button" onclick="closeModal()" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-red-500">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Success -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
            <div class="text-center">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2" id="successModalTitle">Berhasil!</h3>
                <p class="text-sm text-gray-500" id="successModalMessage">Data preferensi anda telah berhasil disimpan.</p>
                <div class="mt-4">
                    <button type="button" onclick="closeSuccessModal()" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-green-500">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function showModal(title, message) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('alertModal').classList.remove('hidden');
            document.getElementById('alertModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('alertModal').classList.add('hidden');
            document.getElementById('alertModal').classList.remove('flex');
        }

        function showSuccessModal() {
            document.getElementById('successModal').classList.remove('hidden');
            document.getElementById('successModal').classList.add('flex');

            // Redirect ke home setelah 2 detik
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 2000);
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('preferenceForm');
            const loaderContainer = document.getElementById('loaderContainer');
            const submitButton = document.getElementById('submitButton');
            const spicinessValue = document.getElementById('spicinessValue');
            const spicinessCheckboxes = document.querySelectorAll('.spiciness-checkbox');

            // Function to update visual state of checkboxes
            function updateCheckboxVisualState(checkbox) {
                const parent = checkbox.closest('label');
                if (checkbox.checked) {
                    parent.classList.add('border-red-500', 'border-4', 'bg-red-500/20');
                    parent.classList.remove('border-gray-300', 'border-2', 'bg-gray-100');
                } else {
                    parent.classList.remove('border-red-500', 'border-4', 'bg-red-500/20');
                    parent.classList.add('border-gray-300', 'border-2', 'bg-gray-100');
                }
            }

            // Handle spiciness checkbox selection
            spicinessCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        spicinessCheckboxes.forEach(cb => {
                            if (cb !== checkbox) {
                                cb.checked = false;
                                updateCheckboxVisualState(cb);
                            }
                        });
                        spicinessValue.value = checkbox.value;
                    } else {
                        spicinessValue.value = '';
                    }
                    updateCheckboxVisualState(checkbox);
                });
            });

            // Limit checkbox selections
            function limitCheckboxes(groupId, max) {
                const checkboxes = document.querySelectorAll(`#${groupId} input[type="checkbox"]`);
                checkboxes.forEach(checkbox => {
                    updateCheckboxVisualState(checkbox);
                    checkbox.addEventListener('change', () => {
                        const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                        if (checkbox.checked && checkedCount > max) {
                            checkbox.checked = false;
                            showModal('Peringatan', `Maksimum ${max} pilihan diperbolehkan untuk ${groupId.replace(/-/g, ' ')}`);
                        }
                        updateCheckboxVisualState(checkbox);
                    });
                });
            }

            // Initialize checkbox limits
            limitCheckboxes('country-group', 3);
            limitCheckboxes('primary-ingredient-group', 3);
            limitCheckboxes('secondary-ingredient-group', 3);

            // Form submission handler
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const countryChecked = document.querySelectorAll('#country-group input[type="checkbox"]:checked').length;
                const primaryIngredientChecked = document.querySelectorAll('#primary-ingredient-group input[type="checkbox"]:checked').length;
                const secondaryIngredientChecked = document.querySelectorAll('#secondary-ingredient-group input[type="checkbox"]:checked').length;
                const spicinessChecked = spicinessValue.value;

                if (countryChecked === 0 || countryChecked > 3) {
                    showModal('Validasi Gagal', 'Silakan pilih 1-3 negara');
                    return;
                }
                if (primaryIngredientChecked === 0 || primaryIngredientChecked > 3) {
                    showModal('Validasi Gagal', 'Silakan pilih 1-3 bahan utama');
                    return;
                }
                if (secondaryIngredientChecked === 0 || secondaryIngredientChecked > 3) {
                    showModal('Validasi Gagal', 'Silakan pilih 1-3 bahan sekunder');
                    return;
                }
                if (!spicinessChecked) {
                    showModal('Validasi Gagal', 'Silakan pilih tingkat kepedasan');
                    return;
                }

                try {
                    loaderContainer.style.display = 'flex';
                    submitButton.disabled = true;
                    form.submit();
                } catch (error) {
                    console.error('Form submission error:', error);
                    loaderContainer.style.display = 'none';
                    submitButton.disabled = false;
                    showModal('Error', 'Terjadi kesalahan saat mengirimkan form. Silakan coba lagi.');
                }
            });

            // Close modal when clicking outside
            document.getElementById('alertModal').addEventListener('click', (e) => {
                if (e.target === e.currentTarget) {
                    closeModal();
                }
            });

            document.getElementById('successModal').addEventListener('click', (e) => {
                if (e.target === e.currentTarget) {
                    closeSuccessModal();
                }
            });
        });
    </script>
@endsection
