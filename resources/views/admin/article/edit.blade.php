@extends('layouts.app')

@section('title', 'Edit Article')

@push('style')
    <style>
        /* Header Styling */
        .section-header {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .section-header h1 {
            font-size: 24px;
            color: #2f2f2f;
            font-weight: bold;
        }

        /* Breadcrumb Styling */
        .section-header .section-header-breadcrumb {
            font-size: 14px;
            color: #f5919d;
        }

        .section-header .section-header-breadcrumb .breadcrumb-item a {
            color: #f5919d;
            text-decoration: none;
        }

        .section-header .section-header-breadcrumb .breadcrumb-item.active {
            color: #2f2f2f;
        }

        .section-header .section-header-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: " / ";
            color: #f5919d;
        }

        /* Form Styling */
        .form-group label {
            font-weight: 600;
            color: #333;
        }

        .required:after {
            content: " *";
            color: red;
        }

        .btn-submit {
            background-color: #f5919d;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background-color: #e77e8f;
        }

        .btn-cancel {
            background-color: #e0e0e0;
            color: #333;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background-color: #c0c0c0;
        }

        /* Image Preview */
        .image-preview {
            width: 200px;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 10px;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .image-preview-text {
            color: #999;
            font-size: 14px;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .section-header .d-flex {
                flex-direction: column;
            }

            .section-header-breadcrumb {
                margin-top: 10px;
            }

            .image-preview {
                width: 150px;
                height: 150px;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h1>Edit Article</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}" style="color: #EB4A36;">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}" style="color: #EB4A36;">Article</a></div>
                        <div class="breadcrumb-item">Edit Article</div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Article</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group">
                                        <label for="title" class="required">Judul</label>
                                        <input type="text" id="title" name="title" 
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title', $article->title) }}" required>
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
                                            value="{{ old('news_date', $article->news_date) }}" required>
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
                                            rows="6" required>{{ old('detail', $article->detail) }}</textarea>
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
                                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        
                                        <div class="image-preview mt-2" id="imagePreview">
                                            @if($article->image)
                                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                                            @else
                                                <span class="image-preview-text">Tidak ada gambar</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-submit mr-2">Perbarui</button>
                                        <a href="{{ route('admin.articles.index') }}" class="btn btn-cancel">Batal</a>
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
            // If no new file is selected, show the existing image or "No image" text
            @if($article->image)
                preview.innerHTML = '<img src="{{ asset("storage/" . $article->image) }}" alt="{{ $article->title }}">';
            @else
                preview.innerHTML = '<span class="image-preview-text">Tidak ada gambar</span>';
            @endif
        }
    }
</script>
@endpush