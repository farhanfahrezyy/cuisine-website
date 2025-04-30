@extends('layouts.layoutpages')

@section('content')
    <div class="uk-container uk-margin-medium-top uk-margin-large-bottom">
        <!-- Modern Page Title with Custom Color Accent Line -->
        <div class="uk-flex uk-flex-middle uk-margin-medium-bottom">
            <div class="uk-position-relative">
                <h1 class="uk-text-bold uk-margin-remove" style="font-size: 2rem;">Checkout</h1>
                <div class="uk-position-absolute"
                    style="height: 4px; width: 40px; background: linear-gradient(to right, #eb4a36, #d32f2f); bottom: -8px; left: 0;">
                </div>
            </div>
        </div>

        <div class="uk-grid-medium" uk-grid>
            <!-- Left Column - Modern Cards -->
            <div class="uk-width-1-1 uk-width-2-3@m">
                <!-- Recipe Card with Modern Styling -->
                <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-box-shadow-small"
                    style="border-radius: 12px; overflow: hidden;">
                    <h2 class="uk-text-bold uk-flex uk-flex-middle" style="font-size: 1.4rem;">
                        <span class="uk-icon uk-margin-small-right"
                            style="background-color: rgba(235, 74, 54, 0.1); padding: 8px; border-radius: 50%;">
                            <span uk-icon="icon: receipt; ratio: 0.9" style="color: #eb4a36;"></span>
                        </span>
                        Resep Pesanan
                    </h2>

                    <div class="uk-flex uk-flex-middle uk-padding-small uk-padding-remove-vertical uk-margin-medium-top">
                        <div class="uk-margin-right">
                            <!-- Modern image presentation -->
                            <div class="uk-border-rounded uk-overflow-hidden uk-box-shadow-small"
                                style="width: 90px; height: 90px; border-radius: 10px;">
                                @if (isset($recipe->image))
                                    <img src="{{ asset('storage/' . $recipe->image) }}"
                                        alt="{{ $recipe->name ?? 'Recipe' }}" width="90" height="90"
                                        style="object-fit: cover;">
                                @else
                                    <div class="uk-background-muted"
                                        style="width: 90px; height: 90px; display: flex; align-items: center; justify-content: center;">
                                        <span uk-icon="icon: image; ratio: 1.2" style="color: #ccc;"></span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <p class="uk-text-bold uk-margin-remove" style="font-size: 1.1rem;">
                                {{ $recipe->name ?? 'Recipe Name' }}</p>
                            <p class="uk-text-bold uk-margin-remove" style="color: #eb4a36; font-size: 1.2rem;">
                                Rp{{ isset($recipe->price) ? number_format($recipe->price, 0, ',', '.') : '0' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Details Card - Modern Design -->
                <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-box-shadow-small"
                    style="border-radius: 12px;">
                    <h2 class="uk-text-bold uk-flex uk-flex-middle" style="font-size: 1.4rem;">
                        <span class="uk-icon uk-margin-small-right"
                            style="background-color: rgba(235, 74, 54, 0.1); padding: 8px; border-radius: 50%;">
                            <span uk-icon="icon: info; ratio: 0.9" style="color: #eb4a36;"></span>
                        </span>
                        Detail Resep
                    </h2>

                    @if (isset($recipe->detail))
                        <p class="uk-text-muted uk-margin-medium-bottom" style="line-height: 1.6;">
                            {{ Str::limit($recipe->detail, 100) }}
                        </p>
                    @endif

                    <div class="uk-child-width-1-2@s uk-grid-small" uk-grid>
                        <div>
                            <div class="uk-background-muted uk-border-rounded uk-padding-small"
                                style="border-radius: 10px; background-color: #f8f8f8;">
                                <p class="uk-text-meta uk-text-uppercase uk-margin-remove-bottom"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #d32f2f;">Negara</p>
                                <p class="uk-text-bold uk-margin-remove-top">{{ $recipe->country ?? '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <div class="uk-background-muted uk-border-rounded uk-padding-small"
                                style="border-radius: 10px; background-color: #f8f8f8;">
                                <p class="uk-text-meta uk-text-uppercase uk-margin-remove-bottom"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #d32f2f;">Rating</p>
                                <p class="uk-text-bold uk-margin-remove-top uk-flex uk-flex-middle">
                                    <span uk-icon="icon: star; ratio: 0.8" style="color: #eb4a36;"></span>
                                    <span
                                        class="uk-margin-small-left">{{ isset($avgRating) ? number_format($avgRating, 1, '.', '') : '0.0' }}</span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <div class="uk-background-muted uk-border-rounded uk-padding-small"
                                style="border-radius: 10px; background-color: #f8f8f8;">
                                <p class="uk-text-meta uk-text-uppercase uk-margin-remove-bottom"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #d32f2f;">Kepedasan</p>
                                <p class="uk-text-bold uk-margin-remove-top">
                                    @if (isset($recipe->spiciness))
                                        @if (is_numeric($recipe->spiciness))
                                            <span class="uk-flex">
                                                @for ($i = 0; $i < min($recipe->spiciness, 5); $i++)
                                                    <span class="uk-margin-small-right" style="color: #eb4a36;">🌶️</span>
                                                @endfor
                                            </span>
                                        @elseif($recipe->spiciness === 'low')
                                            <span class="uk-label" style="background: #e0e0e0; color: #eb4a36;">Tidak
                                                Pedas</span>
                                        @elseif($recipe->spiciness === 'medium')
                                            <span class="uk-label"
                                                style="background: #ffe0b2; color: #eb4a36;">Sedang</span>
                                        @elseif($recipe->spiciness === 'high')
                                            <span class="uk-label" style="background: #ffccbc; color: #d32f2f;">Pedas</span>
                                        @else
                                            {{ $recipe->spiciness }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div>
                            <div class="uk-background-muted uk-border-rounded uk-padding-small"
                                style="border-radius: 10px; background-color: #f8f8f8;">
                                <p class="uk-text-meta uk-text-uppercase uk-margin-remove-bottom"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #d32f2f;">Harga</p>
                                <p class="uk-text-bold uk-margin-remove-top" style="color: #eb4a36;">
                                    Rp{{ isset($recipe->price) ? number_format($recipe->price, 0, ',', '.') : '0' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Modern Payment Card -->
            <div class="uk-width-1-1 uk-width-1-3@m">
                <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-box-shadow-small"
                    style="border-radius: 12px; position: sticky; top: 20px;">
                    <!-- Card Header -->
                    <h2 class="uk-text-bold" style="font-size: 1.4rem; margin-bottom: 20px;">
                        <span class="uk-icon uk-margin-small-right"
                            style="background-color: rgba(235, 74, 54, 0.1); padding: 8px; border-radius: 50%;">
                            <span uk-icon="icon: cart; ratio: 0.9" style="color: #eb4a36;"></span>
                        </span>
                        Rincian Belanja
                    </h2>

                    <!-- Price Details -->
                    <div class="uk-margin-medium-bottom uk-margin-medium-top">
                        <div class="uk-flex uk-flex-between uk-margin-small-bottom">
                            <span class="uk-text-muted">Total Harga</span>
                            <span>Rp{{ isset($recipe->price) ? number_format($recipe->price, 0, ',', '.') : '0' }}</span>
                        </div>

                        <div class="uk-flex uk-flex-between uk-margin-small-bottom">
                            <span class="uk-text-muted">Biaya Admin</span>
                            <span>Rp2.500</span>
                        </div>

                        <div class="uk-flex uk-flex-between uk-margin-small-bottom">
                            <span class="uk-text-muted">No. Rekening</span>
                            <span class="uk-text-bold">178727186272 (BCA)</span>
                        </div>
                    </div>

                    <!-- Total with Modern Styling -->
                    <div
                        style="background-color: rgba(235, 74, 54, 0.05); border-radius: 10px; padding: 15px; margin-bottom: 20px;">
                        <div class="uk-flex uk-flex-between uk-flex-middle">
                            <span class="uk-text-bold">Total Belanja</span>
                            @php
                                $recipePrice = $recipe->price ?? 0;
                                $adminFee = 2500;
                                $totalPrice = $recipePrice + $adminFee;
                            @endphp
                            <span class="uk-text-bold"
                                style="color: #eb4a36; font-size: 1.2rem;">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Modern Upload Section -->
                    <form action="{{ route('payment.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="recipe_id" value="{{ $recipe->id ?? '' }}">

                        <div class="uk-border-rounded uk-text-center uk-margin-bottom"
                            style="border: 2px dashed #e5e5e5; border-radius: 10px; padding: 20px; transition: all 0.2s ease;"
                            id="upload-container">
                            <div
                                style="background-color: rgba(235, 74, 54, 0.1); width: 50px; height: 50px; border-radius: 50%;
                                 display: inline-flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                <span uk-icon="icon: cloud-upload; ratio: 1.2" style="color: #eb4a36;"></span>
                            </div>

                            <p class="uk-text-bold uk-margin-small-bottom" id="file-name">Belum ada berkas dipilih</p>
                            <p class="uk-text-muted uk-text-small uk-margin-small-bottom">
                                Max: 20MB (JPG, PNG, PDF)
                            </p>

                            <input type="file" id="payment_proof" name="payment_proof" class="uk-hidden" required>
                            @error('payment_proof')
                                <div class="uk-text-danger uk-text-small">
                                    {{ $message }}
                                </div>

                            @enderror
                        </div>

                        <!-- Modern Submit Button with Custom Colors -->
                        <button type="submit" class="uk-button uk-width-1-1 uk-margin-top"
                            style="background: linear-gradient(to right, #eb4a36, #d32f2f); color: white; border-radius: 10px;
                                padding: 12px; font-weight: bold; border: none;">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Button Hover Effects */
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(235, 74, 54, 0.3);
            transition: all 0.2s ease;
        }

        /* Upload Container Hover Effects */
        #upload-container:hover {
            border-color: #eb4a36;
            background-color: rgba(235, 74, 54, 0.02);
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('payment_proof');
            const fileNameEl = document.getElementById('file-name');
            const uploadContainer = document.getElementById('upload-container');

            uploadContainer.addEventListener('click', function() {
                fileInput.click();
            });

            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#eb4a36';
                this.style.backgroundColor = 'rgba(235, 74, 54, 0.05)';
            });

            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#e5e5e5';
                this.style.backgroundColor = '';
            });

            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#e5e5e5';
                this.style.backgroundColor = '';

                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    updateFileName(fileInput);
                }
            });

            fileInput.addEventListener('change', function() {
                updateFileName(this);
            });

            function updateFileName(input) {
                if (input.files && input.files[0]) {
                    fileNameEl.textContent = input.files[0].name;
                    fileNameEl.style.color = '#4CAF50';
                } else {
                    fileNameEl.textContent = 'Belum ada berkas dipilih';
                    fileNameEl.style.color = null;
                }
            }
        });


        // This would typically be in your layout file or included JS
        document.addEventListener('DOMContentLoaded', function() {
            // Check for flash messages
            const successMessage = "{{ session('success') }}";
            const errorMessage = "{{ session('error') }}";

            if (successMessage) {
                Swal.fire({
                    title: 'Sukses!',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#eb4a36'
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
@endsection
