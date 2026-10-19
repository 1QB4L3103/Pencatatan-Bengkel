<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang - NIRVANA BENGKEL</title>
    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Sesuai Desain Dashboard */
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
            z-index: 100;
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

        /* Card Custom */
        .card-custom {
            background: white;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            border-top: none;
        }

        .btn-orange {
            background-color: #ff5722;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
        }

        .btn-orange:hover {
            background-color: #e64a19;
            color: white;
        }

        .badge-stok-low {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .badge-stok-safe {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
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
                <a href="{{ route('dashboard') }}" class="nav-link-custom">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="{{ route('transaksi.create') }}" class="nav-link-custom">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Catat Transaksi
                </a>
                <a href="{{ route('transaksi.riwayat') }}" class="nav-link-custom">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi
                </a>
                <a href="{{ route('barang.index') }}" class="nav-link-custom active">
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
            <h4>Kelola Stok Barang</h4>
            <div class="user-profile">
                <span><i class="fa-regular fa-calendar-days me-2"></i> {{ date('d F Y') }}</span>
                <span class="fw-bold ms-3"><i class="fa-solid fa-circle-user fs-5 me-1"></i> {{ Auth::user()->name }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-custom">
            <!-- Header & Live Search Input -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div style="max-width: 350px; width: 100%;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" id="liveSearch" class="form-control border-start-0 ps-0" placeholder="Ketik nama barang untuk cari...">
                    </div>
                </div>

                <button type="button" class="btn btn-orange px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Barang Baru
                </button>
            </div>

            <!-- Tabel Barang -->
            <div class="table-responsive">
                <table class="table align-middle table-hover" id="tabelBarang">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang / Sparepart</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $key => $item)
                        <tr class="barang-row">
                            <td>{{ $barang->firstItem() + $key }}</td>
                            <td class="fw-bold text-dark nama-barang">{{ $item->nama_barang }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $item->stok <= 5 ? 'badge-stok-low' : 'badge-stok-safe' }} px-3 py-2">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td>{{ $item->satuan }}</td>
                            <td class="text-center">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEditBarang{{ $item->id_barang }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Barang (DI DALAM LOOPING AGAR AMAN) -->
                        <div class="modal fade" id="modalEditBarang{{ $item->id_barang }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Edit Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('barang.update', $item->id_barang) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang</label>
                                                <input type="text" name="nama_barang" class="form-control" value="{{ $item->nama_barang }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Harga (Rp)</label>
                                                <input type="number" name="harga" class="form-control" value="{{ $item->harga }}" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Stok</label>
                                                    <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Satuan</label>
                                                    <input type="text" name="satuan" class="form-control" value="{{ $item->satuan }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-orange">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL EDIT -->

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Data barang belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $barang->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="modalTambahBarang" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('barang.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-start">
                            <label class="form-label">Nama Barang / Sparepart</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Oli Yamalube" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="Contoh: 50000" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 text-start">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" name="stok" class="form-control" placeholder="10" required>
                            </div>
                            <div class="col-md-6 mb-3 text-start">
                                <label class="form-label">Satuan</label>
                                <input type="text" name="satuan" class="form-control" placeholder="Botol / Pcs" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-orange">Tambah Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Skrip Live Search Otomatis -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('liveSearch').addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tabelBarang tbody tr.barang-row');

            rows.forEach(function(row) {
                let namaBarang = row.querySelector('.nama-barang').textContent.toLowerCase();
                if (namaBarang.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>