@extends('layouts.app')
@section('title', 'Edit Resep')

@push('style')
    <style>
        /* Modern Gradient Background */
        .section {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            min-height: 100vh;
        }

        /* Glassmorphism Card */
        .card {
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            border: none;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.85);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        }

        /* Vibrant Card Header */
        .card-header {
            background: linear-gradient(135deg, #eb4a36 0%, #ff5e4a 100%);
            padding: 1.75rem;
            border-radius: 16px 16px 0 0 !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: none;
        }

        .card-header h4 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .header-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            font-weight: 500;
        }

        /* Form Sections */
        .form-section {
            background-color: #ffffff;
            border-radius: 16px;
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
            font-weight: 600;
        }

        /* Modern Form Elements */
        .card-body {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-group label {
            font-size: 0.95rem;
            color: #4a5568;
            margin-bottom: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group label i {
            color: #eb4a36;
            font-size: 0.9rem;
        }

        .required:after {
            content: " *";
            color: #eb4a36;
        }

        .form-control {
            height: auto;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            border-color: #eb4a36;
            box-shadow: 0 0 0 4px rgba(235, 74, 54, 0.15);
            background: white;
        }

        textarea.form-control {
            min-height: 180px;
            line-height: 1.7;
            resize: vertical;
        }

        /* Enhanced Image Upload */
        .image-upload-wrapper {
            margin-top: 1rem;
        }

        .image-preview {
            width: 100%;
            max-width: 320px;
            height: 220px;
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            background: #f8fafc;
        }

        .image-preview:hover {
            border-color: #eb4a36;
            background: rgba(235, 74, 54, 0.03);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-text {
            color: #94a3b8;
            font-size: 0.95rem;
            text-align: center;
            padding: 1.5rem;
        }

        .file-upload-label {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background: rgba(235, 74, 54, 0.1);
            color: #eb4a36;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px dashed transparent;
        }

        .file-upload-label:hover {
            background: rgba(235, 74, 54, 0.2);
            border-color: rgba(235, 74, 54, 0.3);
        }

        /* Current Image */
        .current-image-container {
            margin-bottom: 1.5rem;
        }

        .current-image-container h6 {
            font-size: 0.95rem;
            color: #4a5568;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .current-image {
            width: 100%;
            max-width: 320px;
            height: 220px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .current-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .current-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .current-image:hover .current-image-overlay {
            opacity: 1;
        }

        /* Field helpers */
        .text-muted {
            color: #718096;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            display: block;
        }

        /* Modern Buttons */
        .form-actions {
            display: flex;
            gap: 1.25rem;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn {
            padding: 0.875rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            min-width: 140px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        .btn-submit {
            background: linear-gradient(135deg, #eb4a36 0%, #ff5e4a 100%);
            color: white;
            box-shadow: 0 4px 14px rgba(235, 74, 54, 0.25);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #d43a28 0%, #eb4a36 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(235, 74, 54, 0.35);
        }

        .btn-cancel {
            background: white;
            color: #4b5563;
            border: 2px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-cancel:hover {
            background: #f9fafb;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #d1d5db;
        }

        /* Alert styling */
        .alert {
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: flex-start;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .alert-danger ul {
            margin-top: 0.5rem;
            padding-left: 1.5rem;
        }

        /* Row and column spacing */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -0.75rem;
            margin-left: -0.75rem;
        }

        .col-md-4,
        .col-md-6,
        .col-12 {
            position: relative;
            width: 100%;
            padding-right: 0.75rem;
            padding-left: 0.75rem;
        }

        @media (min-width: 768px) {
            .col-md-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }

            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.75rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }

            .image-preview {
                max-width: 100%;
                height: 180px;
            }

            .form-section {
                padding: 1.5rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h1>Edit Resep</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ route('admin.recipes.index') }}">Resep</a></div>
                        <div class="breadcrumb-item">Edit Resep</div>
                    </div>
                </div>
            </div>

            {{-- Error Handling --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div>
                        <strong><i class="fas fa-exclamation-circle mr-2"></i> Kesalahan Validasi!</strong>
                        <p>Silakan periksa kembali input Anda.</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
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
                                <div class="header-badge">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit: {{ $recipe->name }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.recipes.update', $recipe->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-section">
                                        <h5>Informasi Dasar</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="required">
                                                        <i class="fas fa-tag"></i>
                                                        Nama Resep
                                                    </label>
                                                    <input type="text" id="name" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name', $recipe->name) }}" required
                                                        placeholder="Masukkan nama resep">
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category_id" class="required">
                                                        <i class="fas fa-list-alt"></i>
                                                        Kategori
                                                    </label>
                                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                                        id="category_id" name="category_id" required>
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="premium" class="required">
                                                        <i class="fas fa-crown"></i>
                                                        Status Resep
                                                    </label>

                                                    <select class="form-control @error('premium') is-invalid @enderror"
                                                        id="premium" name="premium" required>
                                                        <option value="0"
                                                            {{ old('premium', $recipe->premium) == 0 ? 'selected' : '' }}>
                                                            Regular</option>
                                                        <option value="1"
                                                            {{ old('premium', $recipe->premium) == 1 ? 'selected' : '' }}>
                                                            Premium</option>
                                                    </select>


                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="price" class="required">
                                                        <i class="fas fa-tag"></i>
                                                        Harga Resep (Rp)
                                                    </label>
                                                    <input type="number"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        id="price" name="price"
                                                        value="{{ old('price', $recipe->price) }}" min="0" required>
                                                    @error('price')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="spiciness" class="required">
                                                        <i class="fas fa-pepper-hot"></i>
                                                        Level Pedas
                                                    </label>
                                                    <select class="form-control @error('spiciness') is-invalid @enderror"
                                                        id="spiciness" name="spiciness" required>
                                                        @foreach ($spicinessOptions as $option)
                                                            <option value="{{ $option }}"
                                                                {{ old('spiciness', $recipe->spiciness) == $option ? 'selected' : '' }}>
                                                                @if ($option == 'low')
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
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="country">
                                                        <i class="fas fa-globe-asia"></i>
                                                        Negara Asal
                                                    </label>
                                                    <select class="form-control @error('country') is-invalid @enderror"
                                                        id="country" name="country">
                                                        <option value="">Pilih Negara Asal</option>
                                                        <option value="Indonesia"
                                                            {{ old('country', $recipe->country) == 'Indonesia' ? 'selected' : '' }}>
                                                            Indonesia</option>
                                                        <option value="Italia"
                                                            {{ old('country', $recipe->country) == 'Italia' ? 'selected' : '' }}>
                                                            Italia</option>
                                                        <option value="Jepang"
                                                            {{ old('country', $recipe->country) == 'Jepang' ? 'selected' : '' }}>
                                                            Jepang</option>
                                                        <option value="Western"
                                                            {{ old('country', $recipe->country) == 'Western' ? 'selected' : '' }}>
                                                            Western</option>
                                                        <option value="India"
                                                            {{ old('country', $recipe->country) == 'India' ? 'selected' : '' }}>
                                                            India</option>
                                                        <option value="Korea"
                                                            {{ old('country', $recipe->country) == 'Korea' ? 'selected' : '' }}>
                                                            Korea</option>
                                                    </select>
                                                    @error('country')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section">
                                        <h5>Detail Resep</h5>
                                        <div class="form-group">
                                            <label for="detail">
                                                <i class="fas fa-align-left"></i>
                                                Deskripsi Resep
                                            </label>
                                            <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="5"
                                                placeholder="Tambahkan deskripsi singkat tentang resep">{{ old('detail', $recipe->detail) }}</textarea>
                                            @error('detail')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-section">
                                        <h5>Bahan & Langkah</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ingredients" class="required">
                                                        <i class="fas fa-carrot"></i>
                                                        Bahan-bahan
                                                    </label>
                                                    <small class="text-muted">Satu bahan per baris</small>
                                                    @php
                                                        // First, decode the JSON
                                                        $ingredients = is_string($recipe->ingredients)
                                                            ? json_decode($recipe->ingredients, true)
                                                            : $recipe->ingredients;

                                                        // Filter out any empty array items and join with single newlines
                                                        $cleanIngredients = is_array($ingredients)
                                                            ? implode(
                                                                "\n",
                                                                array_filter(array_map('trim', $ingredients), function (
                                                                    $item,
                                                                ) {
                                                                    return !empty($item) ||
                                                                        $item === '0' ||
                                                                        $item === 0;
                                                                }),
                                                            )
                                                            : $recipe->ingredients;
                                                    @endphp
                                                    <textarea class="form-control @error('ingredients') is-invalid @enderror" id="ingredients" name="ingredients"
                                                        rows="8" required placeholder="Contoh:&#10;2 butir telur&#10;100g tepung&#10;50ml susu">{{ old('ingredients', $cleanIngredients) }}</textarea>
                                                    @error('ingredients')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="instructions" class="required">
                                                        <i class="fas fa-list-ol"></i>
                                                        Langkah-langkah
                                                    </label>
                                                    <small class="text-muted">Satu langkah per baris</small>
                                                    <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions"
                                                        rows="8" required
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
                                                                        if (
                                                                            isset($decoded[0]) &&
                                                                            is_string($decoded[0])
                                                                        ) {
                                                                            $nestedDecoded = json_decode(
                                                                                $decoded[0],
                                                                                true,
                                                                            );
                                                                            if (is_array($nestedDecoded)) {
                                                                                $steps = implode(
                                                                                    "\n",
                                                                                    array_map('trim', $nestedDecoded),
                                                                                );
                                                                            } else {
                                                                                $steps = implode(
                                                                                    "\n",
                                                                                    array_map('trim', $decoded),
                                                                                );
                                                                            }
                                                                        } else {
                                                                            $steps = implode(
                                                                                "\n",
                                                                                array_map('trim', $decoded),
                                                                            );
                                                                        }
                                                                    } else {
                                                                        // If not a valid JSON, use as-is
                                                                        $steps = trim($instructions);
                                                                    }
                                                                }
                                                                // If instructions is already an array
                                                                elseif (is_array($instructions)) {
                                                                    $steps = implode(
                                                                        "\n",
                                                                        array_map('trim', $instructions),
                                                                    );
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
                                        </div>
                                    </div>

                                    <div class="form-section">
                                        <h5>Gambar Resep</h5>
                                        <div class="form-group">
                                            @if ($recipe->image)
                                                <div class="current-image-container">
                                                    <h6>Gambar Saat Ini</h6>
                                                    <div class="current-image">
                                                        <img src="{{ asset('storage/' . $recipe->image) }}"
                                                            alt="{{ $recipe->name }}">
                                                        <div class="current-image-overlay">
                                                            <span class="badge badge-light">Ganti gambar di bawah</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <label for="image">
                                                <i class="fas fa-image"></i>
                                                {{ $recipe->image ? 'Ganti Gambar (Opsional)' : 'Tambah Gambar' }}
                                            </label>

                                            <div class="image-upload-wrapper">
                                                <input type="file" id="image" name="image"
                                                    class="d-none @error('image') is-invalid @enderror" accept="image/*"
                                                    onchange="previewImage()">
                                                <label for="image" class="file-upload-label">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    Pilih Gambar
                                                </label>
                                                <small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small>
                                                @error('image')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div class="image-preview mt-3" id="imagePreview">
                                                    <span
                                                        class="image-preview-text">{{ $recipe->image ? 'Gambar baru akan muncul di sini' : 'Gambar akan muncul di sini setelah dipilih' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-submit">
                                            <i class="fas fa-save"></i>
                                            Simpan Perubahan
                                        </button>
                                        <a href="{{ route('admin.recipes.index') }}" class="btn btn-cancel">
                                            <i class="fas fa-times"></i>
                                            Batal
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
    <script>
        function previewImage() {
            const preview = document.getElementById('imagePreview');
            const fileInput = document.getElementById('image');
            const file = fileInput.files[0];
            const reader = new FileReader();

            preview.innerHTML =
                '<div class="image-preview-text"><i class="fas fa-spinner fa-spin"></i> Memuat gambar...</div>';

            reader.onloadend = function() {
                preview.innerHTML = '';
                const img = document.createElement('img');
                img.src = reader.result;
                preview.appendChild(img);
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML =
                    '<span class="image-preview-text">{{ $recipe->image ? 'Gambar baru akan muncul di sini' : 'Gambar akan muncul di sini setelah dipilih' }}</span>';
            }
        }

        $(document).ready(function() {
            // Premium status price handling
            $('#premium').on('change', function() {
                const price = $('#price');
                if ($(this).val() === '1') {
                    price.prop('min', 1);
                    if (price.val() == 0) {
                        price.val(10000);
                    }
                } else {
                    price.prop('min', 0);
                    price.val(0);
                }
            });

            // Initialize select2 if needed
            if ($.fn.select2) {
                $('#category_id').select2({
                    placeholder: 'Pilih Kategori',
                    allowClear: true
                });

                $('#country').select2({
                    placeholder: 'Pilih Negara Asal',
                    allowClear: true
                });
            }
        });
    </script>
@endpush
