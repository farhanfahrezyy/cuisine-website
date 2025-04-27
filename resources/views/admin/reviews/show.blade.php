<!-- resources/views/reviews/product_reviews.blade.php -->

@extends('layouts.app')

@section('title', 'Review Resep: ' . $recipe->name)

@push('style')
    <!-- DataTables CSS Libraries -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css"> --}}
    <style>
        /* Custom Back Button Style */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-back i {
            font-size: 16px;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Ulasan Produk: {{ $recipe->name }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Ulasan</a></div>
                    <div class="breadcrumb-item">Daftar ulasan resep</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="reviewTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Rating</th>
                                        <th style="width: 60%;">Review</th> <!-- Set width to make review column larger -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recipe->reviews as $review)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $review->name }}</td>
                                            <td>{{ $review->rating }}/5</td>
                                            <td>{{ Str::limit($review->comment, 100) }}</td>
                                            <td>
                                                <form id="deleteForm{{ $review->id }}"
                                                    action="{{ route('admin.reviews.destroy', ['recipe_id' => $recipe->id, 'review_id' => $review->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirmDelete(event, '{{ $review->id }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada ulasan untuk produk ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
