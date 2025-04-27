@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@push('style')
    <style>
        /* Card Styling */
        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Info rows */
        .info-row {
            display: flex;
            border-bottom: 1px solid #f2f2f2;
            padding: 12px 0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            width: 30%;
            color: #6c757d;
            font-weight: 500;
        }
        
        .info-value {
            width: 70%;
            font-weight: 400;
        }
        
        /* Badge styling */
        .badge {
            padding: 6px 10px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 12px;
        }
        
        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .bg-success {
            background-color: #28a745;
            color: white;
        }
        
        .bg-danger {
            background-color: #dc3545;
            color: white;
        }
        
        /* Button styling */
        .btn-primary {
            background-color: #eb4a36;
            border-color: #eb4a36;
        }
        
        .btn-primary:hover {
            background-color: #d25d4e;
            border-color: #d25d4e;
        }
        
        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }
        
        /* Recipe item */
        .recipe-item {
            display: flex;
            padding: 15px;
            border-bottom: 1px solid #f2f2f2;
        }
        
        .recipe-item:last-child {
            border-bottom: none;
        }
        
        .recipe-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 15px;
        }
        
        .recipe-info {
            flex: 1;
        }
        
        .recipe-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .recipe-price {
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        /* Section headers */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f2f2f2;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        
        /* Payment proof */
        .payment-proof-img {
            max-width: 100%;
            max-height: 500px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .proof-upload-form {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-title">
                    <h1>Detail Pembayaran</h1>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Pembayaran</a></div>
                    <div class="breadcrumb-item">Detail Pembayaran</div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <!-- Information Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Informasi Pembayaran</h5>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <div class="info-label">ID Transaksi</div>
                                    <div class="info-value">#{{ $payment->id }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">No. Tracking</div>
                                    <div class="info-value">{{ $payment->no_tracking ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Tanggal</div>
                                    <div class="info-value">{{ $payment->created_at->format('d M Y H:i') }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Total</div>
                                    <div class="info-value">Rp{{ number_format($payment->total_amount, 0, ',', '.') }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Status</div>
                                    <div class="info-value">
                                        @if($payment->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                        @elseif($payment->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($payment->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Update Card for Admin -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Update Status Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.payments.update-status', $payment->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group">
                                        <label for="status">Status Pembayaran</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="approved" {{ $payment->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="rejected" {{ $payment->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_notes">Catatan Admin (opsional)</label>
                                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ $payment->admin_notes ?? '' }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </form>
                            </div>
                        </div>

                        <!-- Items Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Resep yang Dibeli</h5>
                            </div>
                            <div class="card-body p-0">
                                @foreach($paymentItems as $item)
                                    <div class="recipe-item">
                                        @if($item->recipe->image)
                                            <img src="{{ asset('storage/' . $item->recipe->image) }}" alt="{{ $item->recipe->title }}" class="recipe-img">
                                        @else
                                            <div class="recipe-img bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="recipe-info">
                                            <div class="recipe-title">{{ $item->recipe->title }}</div>
                                            <div class="recipe-price">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                            <a href="{{ route('admin.recipes.edit', $item->recipe->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Lihat Resep
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Proof Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Bukti Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                @if($payment->payment_proof)
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran" class="payment-proof-img">
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <p class="mb-0">Bukti pembayaran belum diunggah oleh pengguna.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection