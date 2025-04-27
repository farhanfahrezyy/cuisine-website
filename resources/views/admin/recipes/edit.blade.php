@extends('layouts.app')
@section('title', 'Edit Resep')
@push('style')
<style>
    .form-section {
        background-color: #ffffff;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .form-section h5 {
        font-size: 1.25rem;
        color: #2d3748;
        border-bottom: 2px solid #eb4a36;
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .form-control {
        height: auto;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #eb4a36;
        box-shadow: 0 0 0 3px rgba(235, 74, 54, 0.1);
    }

    textarea.form-control {
        min-height: 120px;
        line-height: 1.6;
    }

    .form-group label {
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        color: #4a5568;
    }

    .form-group small {
        color: #718096;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #eb4a36;
        border: none;
    }

    .btn-primary:hover {
        background: #d43b29;
        transform: translateY(-1px);
    }

    .card-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #eb4a36 0%, #ff6b58 100%);
    }

    .image-preview-container {
        margin-top: 1rem;
    }

    .image-preview {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    .section-header {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Resep</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.recipes.index') }}">Resep</a></div>
                <div class="breadcrumb-item">Edit Resep</div>
            </div>
        </div>

        {{-- Error Handling --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kesalahan Validasi!</strong> Silakan periksa kembali input Anda.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Edit Resep</h4>
                            <div class="header-action">
                                <span class="text-white"><i class="fas fa-edit"></i> Edit Resep</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-section">
                                    <h5>Informasi Dasar</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama Resep <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $recipe->name) }}" required placeholder="Masukkan nama resep">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category_id">Kategori <span class="text-danger">*</span></label>
                                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ (old('category_id', $recipe->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="premium">Status Resep <span class="text-danger">*</span></label>
                                                <select class="form-control @error('premium') is-invalid @enderror"
                                                        id="premium"
                                                        name="premium"
                                                        required>
                                                    <option value="no" {{ (old('premium', $recipe->premium) === 'no') ? 'selected' : '' }}>Regular</option>
                                                    <option value="yes" {{ (old('premium', $recipe->premium) === 'yes') ? 'selected' : '' }}>Premium</option>
                                                </select>
                                                @error('premium')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="price">Harga Resep (Rp) <span class="text-danger">*</span></label>
                                                <input type="number"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       id="price"
                                                       name="price"
                                                       value="{{ old('price', $recipe->price) }}"
                                                       min="0"
                                                       required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="spiciness">Level Pedas <span class="text-danger">*</span></label>
                                                <select class="form-control @error('spiciness') is-invalid @enderror" id="spiciness" name="spiciness" required>
                                                    @foreach($spicinessOptions as $option)
                                                        <option value="{{ $option }}" {{ old('spiciness', $recipe->spiciness) == $option ? 'selected' : '' }}>
                                                            @if($option == 'low')
                                                                Tidak Pedas
                                                            @elseif($option == 'medium')
                                                                Pedas Sedang
                                                            @elseif($option == 'high')
                                                                Sangat Pedas
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('spiciness')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Negara Asal</label>
                                                <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $recipe->country) }}" placeholder="Contoh: Indonesia">
                                                @error('country')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-section">
                                    <h5>Detail Resep</h5>
                                    <div class="row">
                                    </div>
                                    <div class="form-group">
                                        <label for="detail">Deskripsi Resep</label>
                                        <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="3" placeholder="Tambahkan deskripsi singkat tentang resep">{{ old('detail', $recipe->detail) }}</textarea>
                                        @error('detail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-section">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ingredients">Bahan-bahan <span class="text-danger">*</span></label>
                                                <small class="d-block text-muted mb-2">Satu bahan per baris</small>
                                                @php
                                                    // First, decode the JSON
                                                    $ingredients = is_string($recipe->ingredients) ? json_decode($recipe->ingredients, true) : $recipe->ingredients;

                                                    // Filter out any empty array items and join with single newlines
                                                    $cleanIngredients = is_array($ingredients)
                                                        ? implode("\n", array_filter(array_map('trim', $ingredients), function($item) {
                                                            return !empty($item) || $item === '0' || $item === 0;
                                                          }))
                                                        : $recipe->ingredients;
                                                @endphp
                                                <textarea class="form-control @error('ingredients') is-invalid @enderror" id="ingredients" name="ingredients" rows="8" required placeholder="Contoh:&#10;2 butir telur&#10;100g tepung&#10;50ml susu">{{ old('ingredients', $cleanIngredients) }}</textarea>
                                                @error('ingredients')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="instructions">Langkah-langkah <span class="text-danger">*</span></label>
                                                <small class="d-block text-muted mb-2">Satu langkah per baris</small>

                                                <textarea class="form-control @error('instructions') is-invalid @enderror"
                                                        id="instructions"
                                                        name="instructions"
                                                        rows="8"
                                                        required
                                                        placeholder="Contoh:&#10;1. Kocok telur&#10;2. Campur tepung dan susu&#10;3. Aduk hingga rata">
                                                        @php
                                                        // Handle existing data
                                                        $instructions = $recipe->instructions;

                                                        // Initialize $steps as a string
                                                        $steps = '';

                                                        // Handle old input first
                                                        if (old('instructions')) {
                                                            $steps = old('instructions');
                                                        }
                                                        // Handle data from database
                                                        else {
                                                            // If instructions is a JSON string
                                                            if (is_string($instructions)) {
                                                                $decoded = json_decode($instructions, true);

                                                                // If successfully decoded to array
                                                                if (is_array($decoded)) {
                                                                    // Handle potential nested JSON structure
                                                                    if (isset($decoded[0]) && is_string($decoded[0])) {
                                                                        $nestedDecoded = json_decode($decoded[0], true);
                                                                        if (is_array($nestedDecoded)) {
                                                                            $steps = implode("\n", array_map('trim', $nestedDecoded));
                                                                        } else {
                                                                            $steps = implode("\n", array_map('trim', $decoded));
                                                                        }
                                                                    } else {
                                                                        $steps = implode("\n", array_map('trim', $decoded));
                                                                    }
                                                                } else {
                                                                    // If not a valid JSON, use as-is
                                                                    $steps = trim($instructions);
                                                                }
                                                            }
                                                            // If instructions is already an array
                                                            elseif (is_array($instructions)) {
                                                                $steps = implode("\n", array_map('trim', $instructions));
                                                            }
                                                        }

                                                        // Final trim to remove any extra whitespace
                                                        $steps = trim($steps);
                                                    @endphp
                                        {{ $steps }}
                                                </textarea>

                                                @error('instructions')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="image">Gambar Resep</label>
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                @if($recipe->image)
                                                <div class="image-preview-container mt-3">
                                                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}" class="image-preview">
                                                </div>
                                                @endif

                                                <div id="imagePreview" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i> Perbarui Resep
                                    </button>
                                    <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Pilih Kategori',
            allowClear: true
        });

        // Image preview
        $('#image').on('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').html(`
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                `);
                $('.custom-file-label').text(file.name);
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        });

        // Premium status price handling
        $('#premium').on('change', function() {
            const price = $('#price');
            if ($(this).val() === 'yes') {
                price.prop('min', 1);
                if (price.val() == 0) {
                    price.val(10000);
                }
            } else {
                price.prop('min', 0);
                price.val(0);
            }
        });

        // Trigger premium check on load to ensure price field is in the right state
        if ($('#premium').val() === 'no') {
            $('#price').prop('min', 0);
        } else {
            $('#price').prop('min', 1);
        }
    });

    // Form validation
    $('#recipeForm').on('submit', function(event) {
        let valid = true;

        if (!valid) {
            event.preventDefault();
            alert('Harap isi semua bahan dan langkah dengan lengkap');
        }
    });
</script>
@endpush
