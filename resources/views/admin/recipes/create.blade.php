@extends('layouts.app')
@section('title', 'Tambah Resep Baru')
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
        color: #fcfcfc;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #eb4a36 0%, #ff6b58 100%);
    }

    .header-action {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #ffffff;
    }

    .header-action i {
        font-size: 1.1rem;
        color: #ffffff;
    }

    .select2-container .select2-selection--single {
        height: 45px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px;
        padding-left: 1rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
    }

    .image-preview img {
        border-radius: 10px;
        max-width: 100%;
        height: auto;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }

        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .col-md-4, .col-md-6 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Resep Baru</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.recipes.index') }}">Resep</a></div>
                <div class="breadcrumb-item">Tambah Resep</div>
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
                            <h4>Form Tambah Resep</h4>
                            <div class="header-action">
                                <i class="fas fa-utensils mr-2"></i>
                                <span class="text-white">Buat Resep Baru</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-section">
                                    <h5>Informasi Dasar</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama Resep <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama resep">
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
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                                    <option value="no" {{ old('premium') == 'no' ? 'selected' : '' }}>Regular</option>
                                                    <option value="yes" {{ old('premium') == 'yes' ? 'selected' : '' }}>Premium</option>
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
                                                       value="{{ old('price', 0) }}"
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
                                                        <option value="{{ $option }}" {{ old('spiciness') == $option ? 'selected' : '' }}>
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
                                                <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" placeholder="Contoh: Indonesia">
                                                @error('country')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                       {{-- disini --}}
                                    </div>
                                </div>
                                <div class="form-section">
                                    <h5>Detail Resep</h5>
                                    <div class="row">


                                    </div>
                                    <div class="form-group">
                                        <label for="detail">Deskripsi Resep</label>
                                        <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="3" placeholder="Tambahkan deskripsi singkat tentang resep">{{ old('detail') }}</textarea>
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
                                                <textarea class="form-control @error('ingredients') is-invalid @enderror" id="ingredients" name="ingredients" rows="8" required placeholder="Contoh:&#10;2 butir telur&#10;100g tepung&#10;50ml susu">{{ old('ingredients') }}</textarea>
                                                @error('ingredients')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="instructions">Langkah-langkah <span class="text-danger">*</span></label>
                                                <small class="d-block text-muted mb-2">Satu langkah per baris</small>
                                                <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="8" required placeholder="Contoh:&#10;1. Kocok telur&#10;2. Campur tepung dan susu&#10;3. Aduk hingga rata">{{ old('instructions') }}</textarea>
                                                @error('instructions')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="image">Gambar Resep</label>
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div id="imagePreview" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save mr-2"></i> Simpan Resep
                                        </button>
                                        <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                                        </a>
                                    </div>
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
                $('#image-preview').html(`
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                `);
                $('.custom-file-label').text(file.name);
            }

            reader.readAsDataURL(file);
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
    });

    // Dynamic ingredient functions
    function addIngredient() {
        const container = $('#ingredients-container');
        const newItem = `
            <div class="ingredient-item">
                <input type="text"
                       name="ingredients[]"
                       class="form-control"
                       placeholder="Contoh: 2 butir telur"
                       required>
                <button type="button" class="btn btn-danger btn-remove ml-2" onclick="removeIngredient(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.append(newItem);
    }

    function removeIngredient(button) {
        if ($('.ingredient-item').length > 1) {
            $(button).closest('.ingredient-item').remove();
        }
    }

    // Dynamic instruction functions
    function addInstruction() {
        const container = $('#instructions-container');
        const newItem = `
            <div class="instruction-item">
                <input type="text"
                       name="instructions[]"
                       class="form-control"
                       placeholder="Contoh: Kocok telur hingga berbusa"
                       required>
                <button type="button" class="btn btn-danger btn-remove ml-2" onclick="removeInstruction(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.append(newItem);
    }

    function removeInstruction(button) {
        if ($('.instruction-item').length > 1) {
            $(button).closest('.instruction-item').remove();
        }
    }

    // Form validation
    $('#recipeForm').on('submit', function(event) {
        let valid = true;

        // Check ingredients
        $('.ingredient-item input').each(function() {
            if (!$(this).val().trim()) {
                valid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Check instructions
        $('.instruction-item input').each(function() {
            if (!$(this).val().trim()) {
                valid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!valid) {
            event.preventDefault();
            alert('Harap isi semua bahan dan langkah dengan lengkap');
        }
    });
</script>
@endpush



