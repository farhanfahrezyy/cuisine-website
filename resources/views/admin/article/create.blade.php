@extends('layouts.app')

@section('title', 'Tambah Article')

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
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
                    <h1>Tambah Article</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Article</a></div>
                        <div class="breadcrumb-item">Tambah Article</div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Article</h4>
                                <div class="header-badge">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Buat Artikel Baru</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="title" class="required">
                                            <i class="fas fa-heading"></i>
                                            Judul Artikel
                                        </label>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}"
                                            placeholder="Masukkan judul artikel"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="news_date" class="required">
                                            <i class="far fa-calendar-alt"></i>
                                            Tanggal Publikasi
                                        </label>
                                        <input type="date" id="news_date" name="news_date"
                                            class="form-control @error('news_date') is-invalid @enderror"
                                            value="{{ old('news_date', date('Y-m-d')) }}" required>
                                        @error('news_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="detail" class="required">
                                            <i class="fas fa-align-left"></i>
                                            Konten Artikel
                                        </label>
                                        <textarea id="detail" name="detail"
                                            class="form-control @error('detail') is-invalid @enderror"
                                            rows="8"
                                            placeholder="Tulis konten artikel Anda di sini..."
                                            required>{{ old('detail') }}</textarea>
                                        @error('detail')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <i class="fas fa-image"></i>
                                            Gambar Utama
                                        </label>
                                        <div class="image-upload-wrapper">
                                            <input type="file" id="image" name="image"
                                                class="d-none @error('image') is-invalid @enderror"
                                                accept="image/*" onchange="previewImage()">
                                            <label for="image" class="file-upload-label">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                Pilih Gambar
                                            </label>
                                            <small class="d-block text-muted mt-1">Format: JPG, PNG (Maks. 2MB)</small>
                                            @error('image')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <div class="image-preview mt-3" id="imagePreview">
                                                <span class="image-preview-text">Gambar akan muncul di sini setelah dipilih</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-submit">
                                            <i class="fas fa-paper-plane"></i>
                                            Publikasikan
                                        </button>
                                        <a href="{{ route('admin.articles.index') }}" class="btn btn-cancel">
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

        preview.innerHTML = '<div class="image-preview-text"><i class="fas fa-spinner fa-spin"></i> Memuat gambar...</div>';

        reader.onloadend = function() {
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = reader.result;
            preview.appendChild(img);
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '<span class="image-preview-text">Gambar akan muncul di sini setelah dipilih</span>';
        }
    }
</script>
@endpush
