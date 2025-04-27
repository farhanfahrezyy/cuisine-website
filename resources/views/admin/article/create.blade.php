@extends('layouts.app')

@section('title', 'Tambah Article')

@push('style')
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #eb4a36 0%, #ff6b58 100%);
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-action i {
            font-size: 1.1rem;
        }

        .card-header h4 {
            color: white;
            font-weight: 600;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 0.95rem;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .required:after {
            content: " *";
            color: #eb4a36;
        }

        .form-control {
            height: auto;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #eb4a36;
            box-shadow: 0 0 0 3px rgba(235, 74, 54, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
            line-height: 1.6;
        }

        .image-preview {
            width: 100%;
            max-width: 300px;
            height: 200px;
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-text {
            color: #718096;
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 120px;
            justify-content: center;
        }

        .btn-submit {
            background: #eb4a36;
            color: white;
            border: none;
            box-shadow: 0 4px 6px rgba(235, 74, 54, 0.2);
        }

        .btn-submit:hover {
            background: #d43b29;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(235, 74, 54, 0.25);
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .d-flex.gap-3 {
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
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h1>Tambah Article</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}" style="color: #EB4A36;">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}" style="color: #EB4A36;">Article</a></div>
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
                                <div class="header-action">
                                    <span class="text-white"><i class="fas fa-newspaper"></i> Buat Artikel Baru</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="title" class="required">Judul</label>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="news_date" class="required">Tanggal</label>
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
                                        <label for="detail" class="required">Detail</label>
                                        <textarea id="detail" name="detail"
                                            class="form-control @error('detail') is-invalid @enderror"
                                            rows="6" required>{{ old('detail') }}</textarea>
                                        @error('detail')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Gambar</label>
                                        <input type="file" id="image" name="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            accept="image/*" onchange="previewImage()">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="image-preview mt-2" id="imagePreview">
                                            <span class="image-preview-text">Preview gambar akan muncul di sini</span>
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <div class="d-flex gap-3">
                                            <button type="submit" class="btn btn-submit">
                                                <i class="fas fa-save"></i>
                                                Simpan
                                            </button>
                                            <a href="{{ route('admin.articles.index') }}" class="btn btn-cancel">
                                                <i class="fas fa-arrow-left"></i>
                                                Kembali
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
<script>
    function previewImage() {
        var preview = document.getElementById('imagePreview');
        var fileInput = document.getElementById('image');
        var file = fileInput.files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.innerHTML = '';
            var img = document.createElement('img');
            img.src = reader.result;
            preview.appendChild(img);
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '<span class="image-preview-text">Preview gambar akan muncul di sini</span>';
        }
    }
</script>
@endpush
