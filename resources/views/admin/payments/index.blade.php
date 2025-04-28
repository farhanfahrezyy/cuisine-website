@extends('layouts.app')

@section('title', 'Payment List')

@push('style')
    <style>
        /* Table Styling Minimalis */
        .table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        #paymentTable thead th {
            background-color: #f0f0f0;
            color: #333;
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        #paymentTable tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #f2f2f2;
        }

        /* Row Hover Effect */
        #paymentTable tbody tr:hover {
            background-color: #fafafa;
            cursor: pointer;
        }

        .section-header-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Badge styling */
        .badge {
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bg-warning {
            background: linear-gradient(135deg, #ffd54f 0%, #ffca28 100%) !important;
            color: #000000 !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #66bb6a 0%, #43a047 100%) !important;
            color: #ffffff !important;
        }

        .bg-danger {
            background: linear-gradient(135deg, #eb4a36 0%, #d32f2f 100%) !important;
            color: #ffffff !important;
        }

        /* Enhanced Add Button */
        .btn-primary-enhanced {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #eb4a36;
            box-shadow: 0px 4px 15px rgba(245, 145, 157, 0.3);
            border: none;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 10px;
        }

        .btn-primary-enhanced i {
            font-size: 16px;
        }

        .btn-primary-enhanced:hover {
            background: #d25d4e;
            text-decoration: none !important;
            color: white !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .reset-button {
            padding: 8px 15px;
            font-weight: bold;
            border-radius: 8px;
            background-color: #c0c0c0;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            /* Remove underline */
        }

        /* Filter container styling */
        .filter-container {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: flex-start;
            width: 100%;
            margin: 20px 0;
            padding: 15px 0;
        }

        /* Form group base styling */
        .filter-container .form-group {
            margin-bottom: 0;
            min-width: 150px;
        }

        /* Search container styling */
        .filter-container .ml-auto {
            flex: 1;
            max-width: 400px;
            margin-left: auto;
        }

        /* Search input group */
        .filter-container .input-group {
            width: 100%;
        }

        /* Search input field */
        .filter-container .input-group input.form-control {
            height: 42px;
            border-radius: 4px 0 0 4px;
            border: 1px solid #e4e6fc;
            padding: 0 15px;
        }

        /* Search button */
        .filter-container .input-group .input-group-append .btn {
            height: 42px;
            padding: 0 20px;
            background: #eb4a36;
            border: none;
            border-radius: 0 4px 4px 0;
        }

        /* Select box styling */
        .filter-container select.form-control {
            height: 42px;
            min-width: 120px;
            padding: 0 15px;
            border: 1px solid #e4e6fc;
            border-radius: 4px;
        }

        /* Filter button */
        .filter-container .btn-primary {
            height: 42px;
            padding: 0 20px;
            background: #eb4a36;
            border: none;
            border-radius: 4px;
        }

        /* Hover states */
        .filter-container .btn:hover {
            background: #eb4a36;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Action buttons */
        .action-buttons .btn {
            margin: 0 3px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-title">
                    <h1>Riwayat Pembayaran</h1>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Riwayat Pembayaran</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Pembayaran</h2>
                <p class="section-lead">Anda bisa melihat, memverifikasi, dan mengelola pembayaran.</p>

                <div class="card">
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.payments.index') }}" class="filter-container mb-3">
                            <!-- Pagination Dropdown -->
                            <div class="form-group">
                                <select class="form-control selectric" name="pagination" >
                                    <option value="10" {{ request('pagination') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('pagination') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="30" {{ request('pagination') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="40" {{ request('pagination') == 40 ? 'selected' : '' }}>40</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <!-- Status Filter -->
                            <div class="form-group">
                                <select class="form-control selectric" name="status">
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>



                            <!-- Filter Button -->
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.payments.index') }}" class="reset-button">Reset</a>

                            <!-- Search Box aligned to the right -->
                            <div class="ml-auto" style="max-width: 300px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari pembayaran..." name="search"
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="paymentTable" class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>ID Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>#{{ $payment->id }}</td>
                                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                                            <td>Rp{{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($payment->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($payment->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($payment->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    {{-- <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a> --}}
                                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada riwayat pembayaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination with Bootstrap 4 -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $payments->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
