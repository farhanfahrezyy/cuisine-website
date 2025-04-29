@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@push('style')
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light-bg: #f9fafb;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            --card-hover-shadow: 0 14px 28px rgba(0, 0, 0, 0.12), 0 10px 10px rgba(0, 0, 0, 0.10);
        }

        /* Base Typography */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1f2937;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #111827;
            font-size: 1.125rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Info rows */
        .info-row {
            display: flex;
            border-bottom: 1px solid #f3f4f6;
            padding: 1rem 0;
            align-items: center;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            width: 30%;
            color: #6b7280;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .info-value {
            width: 70%;
            font-weight: 400;
        }

        /* Badge styling */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .bg-warning {
            background-color: var(--warning);
            color: white;
        }

        .bg-success {
            background-color: var(--success);
            color: white;
        }

        .bg-danger {
            background-color: var(--danger);
            color: white;
        }

        /* Button styling */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            color: var(--secondary);
            border-color: #e5e7eb;
        }

        .btn-outline-secondary:hover {
            background-color: #f3f4f6;
            color: var(--secondary);
            border-color: #e5e7eb;
        }

        /* Recipe item */
        .recipe-item {
            display: flex;
            padding: 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s;
            align-items: center;
        }

        .recipe-item:hover {
            background-color: #f9fafb;
        }

        .recipe-item:last-child {
            border-bottom: none;
        }

        .recipe-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .recipe-info {
            flex: 1;
        }

        .recipe-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #111827;
        }

        .recipe-price {
            color: var(--secondary);
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        /* Section headers */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: #111827;
        }

        /* Payment proof */
        .payment-proof-container {
            background-color: #f9fafb;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
        }

        .payment-proof-img {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s;
        }

        .payment-proof-img:hover {
            transform: scale(1.02);
        }

        /* Form styling */
        .form-control {
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Alert styling */
        .alert {
            border-radius: 8px;
            padding: 1rem 1.25rem;
        }

        /* Status update card */
        .status-card {
            border-left: 4px solid var(--primary);
        }

        /* Breadcrumb */
        .breadcrumb-item a {
            color: var(--secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-item a:hover {
            color: var(--primary);
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label,
            .info-value {
                width: 100%;
            }

            .info-label {
                margin-bottom: 0.25rem;
            }

            .recipe-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .recipe-img {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-icon">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h1 class="section">Detail Pembayaran</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Pembayaran</a></div>
                    <div class="breadcrumb-item active">#{{ $payment->id }}</div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon mr-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-message">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <!-- Information Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Informasi Pembayaran</h5>
                                <span
                                    class="badge
                                    @if ($payment->status == 'pending') bg-warning
                                    @elseif($payment->status == 'approved') bg-success
                                    @else bg-danger @endif">
                                    {{ $payment->status }}
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <div class="info-label">ID Transaksi</div>
                                    <div class="info-value font-weight-bold">#{{ $payment->id }}</div>
                                </div>
                                
                                <div class="info-row">
                                    <div class="info-label">Tanggal</div>
                                    <div class="info-value">
                                        {{ $payment->created_at->format('d M Y') }}
                                        <span class="text-muted ml-1">{{ $payment->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Metode Pembayaran</div>
                                    <div class="info-value">
                                        {{ $payment->payment_method ?? 'Transfer Bank' }}
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Total Pembayaran</div>
                                    <div class="info-value font-weight-bold text-primary">
                                        Rp{{ number_format($payment->total_amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Resep yang Dibeli</h5>
                                <span class="badge bg-light text-secondary">
                                    {{ count($paymentItems) }} item
                                </span>
                            </div>
                            <div class="card-body p-0">
                                @foreach ($paymentItems as $item)
                                    <div class="recipe-item">
                                        @if ($item->recipe->image)
                                            <img src="{{ asset('storage/' . $item->recipe->image) }}"
                                                alt="{{ $item->recipe->title }}" class="recipe-img">
                                        @else
                                            <div
                                                class="recipe-img bg-light d-flex align-items-center justify-content-center rounded-lg">
                                                <i class="fas fa-utensils text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="recipe-info">
                                            <div class="recipe-title">{{ $item->recipe->title }}</div>
                                            <div class="recipe-price">
                                                Rp{{ number_format($item->recipe->price, 0, ',', '.') }}</div>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('admin.recipes.edit', $item->recipe->id) }}"
                                                    class="btn btn-sm btn-outline-primary mr-2">
                                                    <i class="fas fa-eye mr-1"></i> Detail
                                                </a>
                                                <span class="text-sm text-muted">
                                                    <i class="fas fa-user-edit mr-1"></i> {{ $item->recipe->name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <!-- Status Update Card -->
                        <div class="card status-card">
                            <div class="card-header">
                                <h5>Update Status Pembayaran</h5>
                                <i class="fas fa-exchange-alt text-primary"></i>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.payments.update-status', $payment->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group">
                                        <label for="status" class="font-weight-bold mb-2">Status</label>
                                        <select class="form-control selectric" id="status" name="status">
                                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>
                                                Menunggu Konfirmasi</option>
                                            <option value="approved"
                                                {{ $payment->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="rejected"
                                                {{ $payment->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="admin_notes" class="font-weight-bold mb-2">Catatan (Opsional)</label>
                                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"
                                            placeholder="Masukkan catatan jika diperlukan...">{{ $payment->admin_notes ?? '' }}</textarea>
                                    </div> --}}
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Payment Proof Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Bukti Pembayaran</h5>
                                <i class="fas fa-receipt text-primary"></i>
                            </div>
                            <div class="card-body">
                                @if ($payment->payment_proof)
                                    <div class="payment-proof-container">
                                        <img src="{{ asset('storage/' . $payment->payment_proof) }}"
                                            alt="Bukti Pembayaran" class="payment-proof-img">
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-expand mr-1"></i> Lihat Fullscreen
                                        </a>
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <h4>Bukti Pembayaran Belum Diunggah</h4>
                                        <p class="text-muted">Pengguna belum mengunggah bukti pembayaran untuk transaksi
                                            ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Customer Info Card -->
                        <!-- Customer Info Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Informasi Pembeli</h5>
                                <i class="fas fa-user-circle text-primary"></i>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <div class="info-label">Nama</div>
                                    <div class="info-value">
                                        {{ $payment->user->name ?? 'Tidak tersedia' }}
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Email</div>
                                    <div class="info-value">
                                        {{ $payment->user->email ?? 'Tidak tersedia' }}
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Bergabung</div>
                                    <div class="info-value">
                                        @if ($payment->user)
                                            {{ $payment->user->created_at->diffForHumans() }}
                                            <span
                                                class="text-muted ml-1">({{ $payment->user->created_at->format('d M Y') }})</span>
                                        @else
                                            Tidak tersedia
                                        @endif
                                    </div>
                                </div>
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
        // Initialize selectric for better select inputs
        $(document).ready(function() {
            $('.selectric').selectric();
        });
    </script>
@endpush
