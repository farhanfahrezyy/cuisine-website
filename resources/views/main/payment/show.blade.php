@extends('layouts.layoutpages')

@section('content')
<div style="max-width: 800px; margin: 30px auto; padding: 0 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 24px; color: #2c3e50;">Detail Transaksi</h1>
            <p style="margin: 5px 0 0; color: #7f8c8d; font-size: 14px;">No. Tracking: {{ $payment->no_tracking }}</p>
        </div>
        <a href="{{ route('home') }}" style="text-decoration: none; padding: 8px 15px; background: #ecf0f1; border-radius: 5px; color: #2c3e50; font-size: 14px;">
            ← Kembali
        </a>
    </div>

    @if(session('success'))
    <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #c8e6c9;">
        ✔️ {{ session('success') }}
    </div>
    @endif

    <!-- Info Box -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; color: #95a5a6; font-size: 13px; margin-bottom: 5px;">Tanggal</label>
                <div style="color: #2c3e50; font-weight: 500;">{{ $payment->created_at->format('d/m/Y H:i') }}</div>
            </div>
            
            <div>
                <label style="display: block; color: #95a5a6; font-size: 13px; margin-bottom: 5px;">Total</label>
                <div style="color: #2c3e50; font-weight: 500;">Rp{{ number_format($payment->total_amount, 0, ',', '.') }}</div>
            </div>
            
            <div>
                <label style="display: block; color: #95a5a6; font-size: 13px; margin-bottom: 5px;">Status</label>
                @if($payment->status == 'pending')
                    <span style="display: inline-flex; align-items: center; background: #fff3e0; color: #ef6c00; padding: 5px 12px; border-radius: 20px; font-size: 13px;">
                        <div style="width: 8px; height: 8px; background: #ef6c00; border-radius: 50%; margin-right: 8px;"></div>
                        Menunggu Konfirmasi
                    </span>
                @elseif($payment->status == 'approved')
                    <span style="display: inline-flex; align-items: center; background: #e8f5e9; color: #2e7d32; padding: 5px 12px; border-radius: 20px; font-size: 13px;">
                        <div style="width: 8px; height: 8px; background: #2e7d32; border-radius: 50%; margin-right: 8px;"></div>
                        Disetujui
                    </span>
                @elseif($payment->status == 'rejected')
                    <span style="display: inline-flex; align-items: center; background: #ffebee; color: #c62828; padding: 5px 12px; border-radius: 20px; font-size: 13px;">
                        <div style="width: 8px; height: 8px; background: #c62828; border-radius: 50%; margin-right: 8px;"></div>
                        Ditolak
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Resep Section -->
    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 20px; color: #2c3e50; font-size: 18px;">Resep Dibeli</h3>
        
        @foreach($paymentItems as $item)
        <div style="border: 1px solid #f0f0f0; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
            <div style="display: flex; gap: 15px; align-items: center;">
                <div class="flex-shrink-0">
                    @if($item->recipe->image)
                    <img src="{{ asset('storage/'.$item->recipe->image) }}" alt="{{ $item->recipe->name }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                    <div style="width: 80px; height: 80px; background-color: #f8f9fa;" class="rounded d-flex align-items-center justify-content-center">
                        <i class="bi bi-card-image text-muted"></i>
                    </div>
                    @endif
                </div>
                <div style="flex-grow: 1;">
                    <div style="font-weight: 500; color: #2c3e50; margin-bottom: 4px;">{{ $item->recipe->name }}</div>
                    <div style="color: #95a5a6; font-size: 14px;">Rp{{ number_format($item->recipe->price, 0, ',', '.') }}</div>
                    @if($payment->status == 'approved')
                    <a href="{{ route('recipes.show', $item->recipe->id) }}" style="display: inline-block; margin-top: 12px; font-size: 13px; color: #3498db; text-decoration: none; padding: 6px 12px; border: 1px solid #3498db; border-radius: 5px;">
                        Lihat Resep →
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Bukti Pembayaran Section -->
    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 20px; color: #2c3e50; font-size: 18px;">Bukti Pembayaran</h3>
        
        @if($payment->payment_proof)
        <div style="text-align: center; position: relative;">
            <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                 alt="Bukti Pembayaran" 
                 style="max-height: 400px; width: auto; border-radius: 8px; border: 1px solid #eee; cursor: zoom-in;"
                 onclick="this.style.maxHeight = this.style.maxHeight === 'none' ? '400px' : 'none'">
            
            <div style="color: #95a5a6; font-size: 13px; margin-top: 10px;">
                Klik gambar untuk memperbesar/mengecilkan
            </div>
        </div>
        @else
        <div style="background: #fff8e1; color: #ef6c00; padding: 15px; border-radius: 8px; border: 1px solid #ffe082; margin-bottom: 20px;">
            ⚠️ Belum ada bukti pembayaran yang diunggah
        </div>
        
        @if($payment->status == 'pending')
        <form action="{{ route('payment.upload-proof', $payment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; color: #2c3e50; font-size: 14px; margin-bottom: 8px;">
                    Upload Bukti Transfer
                    <span style="color: #e74c3c;">*</span>
                </label>
                
                <label style="display: block; border: 2px dashed #bdc3c7; border-radius: 8px; padding: 25px; text-align: center; cursor: pointer;">
                    <input type="file" name="payment_proof" required 
                           style="display: none;" 
                           onchange="document.getElementById('fileName').textContent = this.files[0].name">
                    <div style="color: #7f8c8d; font-size: 14px;">
                        <span style="color: #3498db; font-weight: 500;">Pilih File</span> atau drag ke sini
                    </div>
                    <div id="fileName" style="color: #95a5a6; font-size: 13px; margin-top: 8px;"></div>
                </label>
            </div>
            
            <button type="submit" 
                    style="background: #3498db; color: white; padding: 10px 25px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; transition: background 0.3s;"
                    onmouseover="this.style.background='#2980b9'" 
                    onmouseout="this.style.background='#3498db'">
                📤 Unggah Sekarang
            </button>
        </form>
        @endif
        @endif
    </div>
</div>
@endsection