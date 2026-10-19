<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - NIRVANA BENGKEL</title>
    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        
        .sidebar {
            width: 260px; height: 100vh; background-color: #0b192c; position: fixed; top: 0; left: 0;
            color: white; display: flex; flex-direction: column; justify-content: space-between; padding: 20px 15px; z-index: 100;
        }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; padding: 10px; margin-bottom: 20px; }
        .sidebar-brand i { background: #ff5722; padding: 10px; border-radius: 50%; font-size: 20px; }
        .sidebar-brand span { font-size: 18px; font-weight: 800; line-height: 1.2; }
        .nav-link-custom {
            display: flex; align-items: center; gap: 12px; color: #94a3b8; padding: 12px 15px;
            border-radius: 10px; text-decoration: none; font-weight: 600; margin-bottom: 5px; transition: all 0.3s;
        }
        .nav-link-custom:hover, .nav-link-custom.active { background-color: #ff5722; color: white; }

        .main-content { margin-left: 260px; padding: 25px 30px; }
        .top-navbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; }
        .top-navbar h4 { font-weight: 800; color: #0f172a; margin: 0; }

        .card-custom { background: white; border-radius: 14px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .table th { background-color: #f1f5f9; color: #334155; font-weight: 600; }
        .btn-orange { background-color: #ff5722; color: white; font-weight: 600; border: none; border-radius: 8px; }
        .btn-orange:hover { background-color: #e64a19; color: white; }
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
                <a href="{{ route('transaksi.riwayat') }}" class="nav-link-custom active">
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
        <div class="top-navbar">
            <h4>Riwayat Transaksi</h4>
            <div class="text-secondary fw-semibold fs-6">
                <i class="fa-regular fa-calendar-days me-2"></i> {{ date('d F Y') }}
            </div>
        </div>

        <div class="card-custom">
            <!-- Form Pencarian -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <form action="{{ route('transaksi.riwayat') }}" method="GET" class="d-flex gap-2" style="max-width: 350px; width: 100%;">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nopol / No. Transaksi..." value="{{ $search }}">
                    <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <!-- Tabel Riwayat -->
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Nopol</th>
                            <th>Pelanggan</th>
                            <th>Total Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($transaksi) && count($transaksi) > 0): ?>
                            <?php foreach ($transaksi as$t): ?>
                                <tr>
                                    <td class="fw-bold text-primary">{{ $t->id_transaksi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y H:i') }}</td>
                                    <td><span class="badge bg-dark px-3 py-2 fs-7">{{ $t->no_polisi }}</span></td>
                                    <td>{{ $t->nama_pelanggan }}</td>
                                    <td class="fw-bold text-success">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-info btn-detail" data-id="{{ $t->id_transaksi }}">
                                            <i class="fa-solid fa-eye me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat transaksi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transaksi->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modal Detail Transaksi -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Detail Transaksi - <span id="detailIdTrx" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 fs-7">
                        <div class="col-6">
                            <p class="mb-1"><strong>Nopol:</strong> <span id="detailNopol"></span></p>
                            <p class="mb-1"><strong>Pelanggan:</strong> <span id="detailPelanggan"></span></p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-1"><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
                        </div>
                    </div>

                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="detailItemsContainer">
                            <!-- Detail item akan diisi via JS -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end fw-bold">Total</th>
                                <th class="text-end fw-bold text-danger fs-6" id="detailTotalHarga"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap & AJAX Detail -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-detail').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;

                fetch(`/transaksi/detail/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        let trx = data.transaksi;
                        let details = data.detail;

                        document.getElementById('detailIdTrx').textContent = trx.id_transaksi;
                        document.getElementById('detailNopol').textContent = trx.no_polisi;
                        document.getElementById('detailPelanggan').textContent = trx.nama_pelanggan;
                        document.getElementById('detailTanggal').textContent = trx.tanggal;
                        document.getElementById('detailTotalHarga').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(trx.total_harga);

                        let container = document.getElementById('detailItemsContainer');
                        container.innerHTML = '';

                        details.forEach(item => {
                            // Prioritas nama item: kolom 'nama_item', jika kosong baru ambil dari relasi barang, fallback ke 'Jasa / Servis'
                            let namaItem = item.nama_item ? item.nama_item : (item.barang ? item.barang.nama_barang : 'Jasa / Servis');
                            
                            // Jika id_barang kosong, anggap sebagai Jasa (Qty dikosongkan/diisi -)
                            let isJasa = !item.id_barang;
                            let qty = isJasa ? '-' : item.qty;
                            let subtotal = 'Rp ' + new Intl.NumberFormat('id-ID').format(item.subtotal);

                            container.innerHTML += `
                                <tr>
                                    <td>${namaItem} ${isJasa ? '<span class="badge bg-secondary ms-1 fs-8">Jasa</span>' : ''}</td>
                                    <td class="text-center">${qty}</td>
                                    <td class="text-end">${subtotal}</td>
                                </tr>
                            `;
                        });

                        let modal = new bootstrap.Modal(document.getElementById('modalDetail'));
                        modal.show();
                    })
                    .catch(error => alert('Gagal mengambil data detail transaksi!'));
            });
        });
    </script>
</body>
</html>