<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NIRVANA BENGKEL</title>
    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Sesuai Desain */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #0b192c;
            position: fixed;
            top: 0;
            left: 0;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 15px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .sidebar-brand i {
            background: #ff5722;
            padding: 10px;
            border-radius: 50%;
            font-size: 20px;
        }

        .sidebar-brand span {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.2;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            padding: 12px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 5px;
            transition: all 0.3s;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background-color: #ff5722;
            color: white;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 260px;
            padding: 25px 30px;
        }

        /* Top Navbar */
        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .top-navbar h4 {
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Cards Summary */
        .card-summary {
            background: white;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            height: 100%;
        }

        .card-number {
            font-size: 36px;
            font-weight: 800;
            color: #ff5722;
        }

        /* Table Custom */
        .table-card {
            background: white;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 20px;
            margin-top: 25px;
        }

        .table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            border-top: none;
        }

        .btn-detail {
            background-color: #fff7ed;
            color: #ea580c;
            border: 1px solid #ffedd5;
            padding: 5px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-detail:hover {
            background-color: #ff5722;
            color: white;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div>
            <div class="sidebar-brand">
                <i class="fa-solid fa-wrench text-white"></i>
                <span>NIRVANA<br>BENGKEL</span>
            </div>
            
            <div class="nav flex-column">
                <a href="{{ route('dashboard') }}" class="nav-link-custom active">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="{{ route('transaksi.create') }}" class="nav-link-custom">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Catat Transaksi
                </a>
                <a href="{{ route('transaksi.riwayat') }}" class="nav-link-custom">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi
                </a>
                <a href="{{ route('barang.index') }}" class="nav-link-custom">
                    <i class="fa-solid fa-box"></i> Kelola Barang
                </a>
            </div>
        </div>

        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link-custom text-danger border-0 bg-transparent w-100 text-start">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <h4>Dashboard</h4>
            <div class="user-profile">
                <span><i class="fa-regular fa-calendar-days me-2"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <span class="fw-bold ms-3"><i class="fa-solid fa-circle-user fs-5 me-1"></i> {{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>

        <!-- Greeting -->
        <div class="mb-4">
            <h3 class="fw-bold text-dark">Haloo Admin...</h3>
            <p class="text-muted">Berikut Ringkasan Kegiatan Hari Ini</p>
        </div>

        <!-- Row Cards -->
        <div class="row g-4">
            <!-- Card 1: Hari Ini -->
            <div class="col-md-7">
                <div class="card-summary d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted fw-bold text-uppercase fs-7">Hari Ini</span>
                        <div class="card-number">{{ $transaksiHariIni }} <span class="fs-5 text-dark fw-normal">Transaksi</span></div>
                        <div class="mt-3">
                            <span class="text-muted d-block fs-7">Total Pendapatan</span>
                            <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div>
                        <i class="fa-solid fa-receipt fa-4x text-warning opacity-75"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Stok Menipis -->
            <div class="col-md-5">
                <div class="card-summary d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted fw-bold text-uppercase fs-7">Stok Menipis/Habis</span>
                        <div class="card-number">{{ $stokMenipis }} <span class="fs-5 text-dark fw-normal">Barang</span></div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('barang.index') }}" class="nav-link-custom">
                            <i class="fa-solid fa-box"></i> Kelola Barang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Transaksi Terbaru -->
        <div class="table-card">
            <h5 class="fw-bold mb-3 text-dark">Transaksi Terbaru</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nopol</th>
                            <th>Nama</th>
                            <th>Total</th>
                            <th class="text-end">Lainnya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $trx)
                        <tr>
                            <td>{{ date('d F Y H:i', strtotime($trx->tanggal)) }}</td>
                            <td>{{ $trx->no_polisi }}</td>
                            <td>{{ $trx->nama_pelanggan }}</td>
                            <td class="fw-bold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="#" class="btn btn-detail">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data transaksi hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>