<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Transaksi - NIRVANA BENGKEL</title>
    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Master */
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

        .main-content {
            margin-left: 260px;
            padding: 25px 30px;
        }

        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .top-navbar h4 {
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .panel-tambah-item {
            background-color: #f3e8e8;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .nav-tabs-custom {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 15px;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            color: #64748b;
            font-weight: 700;
            font-size: 16px;
            padding-bottom: 8px;
            margin-right: 20px;
            background: transparent;
            cursor: pointer;
        }

        .nav-tabs-custom .nav-link.active {
            color: #ff5722;
            border-bottom: 3px solid #ff5722;
        }

        .list-barang-container {
            background: white;
            border-radius: 10px;
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #e2e8f0;
        }

        .item-barang-btn {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px 15px;
            border: none;
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            color: #1e293b;
            transition: background 0.2s;
        }

        .item-barang-btn:hover {
            background-color: #fff7ed;
            color: #ff5722;
        }

        .table-keranjang {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .table-keranjang th {
            background-color: white;
            color: #0f172a;
            font-weight: 700;
            border-bottom: 2px solid #f1f5f9;
        }

        .btn-qty {
            width: 28px;
            height: 28px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #cbd5e1;
            background: white;
            font-weight: bold;
        }

        .btn-simpan-trx {
            background-color: #f97316;
            color: white;
            font-weight: 800;
            font-size: 16px;
            padding: 12px 30px;
            border-radius: 10px;
            border: none;
            transition: all 0.3s;
        }

        .btn-simpan-trx:hover {
            background-color: #ea580c;
            color: white;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .total-text {
            font-size: 32px;
            font-weight: 900;
            color: #f97316;
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
                <a href="{{ route('transaksi.create') }}" class="nav-link-custom active">
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
        <!-- Top Navbar (Hanya Tanggal) -->
        <div class="top-navbar">
            <h4>Catat Transaksi</h4>
            <div class="text-secondary fw-semibold fs-6">
                <i class="fa-regular fa-calendar-days me-2"></i> {{ date('d F Y') }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
            @csrf
            
            <h5 class="fw-bold text-dark mb-3">Informasi Transaksi</h5>

            <!-- Inputs Header -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark fs-7">No. Transaksi</label>
                    <input type="text" class="form-control bg-light fw-bold text-secondary py-2" value="TRX-{{ date('Ymd') }}-AUTO" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark fs-7">Nopol ( Kendaraan )</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-car text-dark"></i></span>
                        <input type="text" name="no_polisi" class="form-control border-start-0 ps-0 text-uppercase fw-bold" placeholder="RX-7878-KKK" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark fs-7">Nama Pelanggan ( Opsional )</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-user text-dark"></i></span>
                        <input type="text" name="nama_pelanggan" class="form-control border-start-0 ps-0 fw-bold" placeholder="Bahuela" value="Umum">
                    </div>
                </div>
            </div>

            <!-- Tanggal -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark fs-7">Tanggal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-calendar text-secondary"></i></span>
                        <input type="text" class="form-control bg-light border-start-0 ps-0 text-secondary fw-semibold" value="{{ date('d-F-Y H:i') }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Panel Tambah Item -->
            <div class="panel-tambah-item">
                <h5 class="fw-bold text-dark mb-3">Tambah Item</h5>

                <!-- Tabs Barang & Jasa -->
                <div class="nav nav-tabs-custom">
                    <button type="button" class="nav-link active" id="tabBarang">Barang</button>
                    <button type="button" class="nav-link" id="tabJasa">Jasa</button>
                </div>

                <div class="row g-3">
                    <!-- Area Kiri: Pilihan Barang ATAU Form Input Jasa -->
                    <div class="col-md-4">
                        <!-- TAMPILAN 1: PILIHAN BARANG -->
                        <div id="sectionBarang">
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" id="searchBarang" class="form-control border-start-0 ps-0" placeholder="Cari Barang...">
                            </div>

                            <div class="list-barang-container">
                                <?php if (isset($barang) && count($barang) > 0): ?>
                                    <?php foreach ($barang as$b): ?>
                                        <button type="button" class="item-barang-btn btn-pilih-barang" 
                                            data-id="{{ $b->id_barang }}" 
                                            data-nama="{{ $b->nama_barang }}" 
                                            data-harga="{{ $b->harga }}"
                                            data-stok="{{ $b->stok }}">
                                            {{ $b->nama_barang }}
                                        </button>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="p-3 text-muted text-center fs-7">Barang belum ada / stok habis</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- TAMPILAN 2: INPUT 2 KOLOM JASA -->
                        <div id="sectionJasa" style="display: none;">
                            <div class="bg-white p-3 rounded-3 border">
                                <div class="mb-2">
                                    <label class="form-label fw-bold fs-7 text-dark">Nama Jasa / Servis</label>
                                    <input type="text" id="inputNamaJasa" class="form-control form-control-sm" placeholder="Contoh: Servis Karburator">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold fs-7 text-dark">Harga Jasa (Rp)</label>
                                    <input type="number" id="inputHargaJasa" class="form-control form-control-sm" placeholder="Contoh: 35000">
                                </div>
                                <button type="button" class="btn btn-orange btn-sm w-100 fw-bold" id="btnTambahJasa">
                                    <i class="fa-solid fa-plus me-1"></i> Tambah Jasa
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Area Kanan: Tabel Keranjang Belanja -->
                    <div class="col-md-8">
                        <div class="table-responsive table-keranjang">
                            <table class="table align-middle m-0" id="tabelKeranjang">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Harga</th>
                                        <th style="width: 110px;" class="text-center">Qty</th>
                                        <th>SubTotal</th>
                                        <th style="width: 50px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="keranjangContainer">
                                    <!-- Item akan masuk di sini via JS -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Total & Tombol Simpan -->
                        <div class="d-flex justify-content-end align-items-center gap-4 mt-4">
                            <div class="d-flex align-items-center gap-3">
                                <span class="fs-4 fw-bold text-dark">Total</span>
                                <span class="total-text" id="grandTotalText">Rp0</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-simpan-trx">
                                <i class="fa-solid fa-file-lines me-2"></i> Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- JS Bootstrap & Interaksi Kasir -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let itemCounter = 0;

        function formatRupiah(angka) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(angka);
        }

        // TAB SWITCHING (Barang vs Jasa)
        const tabBarang = document.getElementById('tabBarang');
        const tabJasa = document.getElementById('tabJasa');
        const sectionBarang = document.getElementById('sectionBarang');
        const sectionJasa = document.getElementById('sectionJasa');

        tabBarang.addEventListener('click', function() {
            tabBarang.classList.add('active');
            tabJasa.classList.remove('active');
            sectionBarang.style.display = 'block';
            sectionJasa.style.display = 'none';
        });

        tabJasa.addEventListener('click', function() {
            tabJasa.classList.add('active');
            tabBarang.classList.remove('active');
            sectionBarang.style.display = 'none';
            sectionJasa.style.display = 'block';
            document.getElementById('inputNamaJasa').focus();
        });

        // LIVE SEARCH BARANG
        document.getElementById('searchBarang').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let buttons = document.querySelectorAll('.btn-pilih-barang');
            buttons.forEach(btn => {
                let txt = btn.textContent.toLowerCase();
                btn.style.display = txt.includes(filter) ? '' : 'none';
            });
        });

        // TAMBAH ITEM BARANG
        document.querySelectorAll('.btn-pilih-barang').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                let nama = this.dataset.nama;
                let harga = parseFloat(this.dataset.harga);
                let stok = parseInt(this.dataset.stok);

                let existingRow = document.querySelector(`tr[data-id="${id}"][data-jenis="barang"]`);
                if (existingRow) {
                    let qtyInput = existingRow.querySelector('.qty-input');
                    let currentQty = parseInt(qtyInput.value);
                    if (currentQty < stok) {
                        qtyInput.value = currentQty + 1;
                        updateRow(existingRow);
                    } else {
                        alert('Stok barang terbatas!');
                    }
                } else {
                    tambahRowBarang(id, nama, harga, stok);
                }
            });
        });

        function tambahRowBarang(id, nama, harga, stok) {
            let container = document.getElementById('keranjangContainer');
            let tr = document.createElement('tr');
            tr.setAttribute('data-id', id);
            tr.setAttribute('data-jenis', 'barang');
            tr.setAttribute('data-harga', harga);
            tr.setAttribute('data-stok', stok);

            tr.innerHTML = `
                <td class="fw-bold text-dark">
                    ${nama}
                    <input type="hidden" name="items[${itemCounter}][jenis]" value="barang">
                    <input type="hidden" name="items[${itemCounter}][id_barang]" value="${id}">
                </td>
                <td class="fw-bold">${formatRupiah(harga)}</td>
                <td class="text-center">
                    <div class="d-flex align-items-center justify-content-center gap-1">
                        <button type="button" class="btn btn-qty btn-minus">-</button>
                        <input type="text" name="items[${itemCounter}][qty]" class="form-control form-control-sm text-center qty-input fw-bold" style="width: 40px;" value="1" readonly>
                        <button type="button" class="btn btn-qty btn-plus">+</button>
                    </div>
                </td>
                <td class="fw-bold text-dark subtotal-text">${formatRupiah(harga)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm text-dark btn-hapus"><i class="fa-solid fa-trash-can fs-5"></i></button>
                </td>
            `;

            container.appendChild(tr);
            itemCounter++;
            hitungTotal();
        }

        // TAMBAH ITEM JASA (Dua Kolom)
        function eksekusiTambahJasa() {
            let namaJasaInput = document.getElementById('inputNamaJasa');
            let hargaJasaInput = document.getElementById('inputHargaJasa');

            let namaJasa = namaJasaInput.value.trim();
            let hargaJasa = parseFloat(hargaJasaInput.value);

            if (!namaJasa || isNaN(hargaJasa) || hargaJasa <= 0) {
                alert('Harap isi Nama Jasa dan Harga Jasa dengan benar!');
                return;
            }

            let container = document.getElementById('keranjangContainer');
            let tr = document.createElement('tr');
            tr.setAttribute('data-jenis', 'jasa');
            tr.setAttribute('data-harga', hargaJasa);

            tr.innerHTML = `
                <td class="fw-bold text-dark">
                    ${namaJasa} <span class="badge bg-secondary ms-1 fs-8">Jasa</span>
                    <input type="hidden" name="items[${itemCounter}][jenis]" value="jasa">
                    <input type="hidden" name="items[${itemCounter}][nama_jasa]" value="${namaJasa}">
                    <input type="hidden" name="items[${itemCounter}][harga_jasa]" value="${hargaJasa}">
                </td>
                <td class="fw-bold">${formatRupiah(hargaJasa)}</td>
                <td class="text-center text-muted fw-semibold">-</td>
                <td class="fw-bold text-dark subtotal-text">${formatRupiah(hargaJasa)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm text-dark btn-hapus"><i class="fa-solid fa-trash-can fs-5"></i></button>
                </td>
            `;

            container.appendChild(tr);
            itemCounter++;
            hitungTotal();

            // Reset Input
            namaJasaInput.value = '';
            hargaJasaInput.value = '';
            namaJasaInput.focus();
        }

        document.getElementById('btnTambahJasa').addEventListener('click', eksekusiTambahJasa);

        document.getElementById('inputHargaJasa').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                eksekusiTambahJasa();
            }
        });

        // EVENT LISTENER MINUS, PLUS, DAN HAPUS
        document.getElementById('keranjangContainer').addEventListener('click', function(e) {
            let tr = e.target.closest('tr');
            if (!tr) return;

            let jenis = tr.dataset.jenis;

            if (jenis === 'barang') {
                let qtyInput = tr.querySelector('.qty-input');
                let currentQty = parseInt(qtyInput.value);
                let stok = parseInt(tr.dataset.stok);

                if (e.target.classList.contains('btn-minus')) {
                    if (currentQty > 1) {
                        qtyInput.value = currentQty - 1;
                        updateRow(tr);
                    }
                } else if (e.target.classList.contains('btn-plus')) {
                    if (currentQty < stok) {
                        qtyInput.value = currentQty + 1;
                        updateRow(tr);
                    } else {
                        alert('Stok barang terbatas!');
                    }
                }
            }

            if (e.target.closest('.btn-hapus')) {
                tr.remove();
                hitungTotal();
            }
        });

        function updateRow(tr) {
            let harga = parseFloat(tr.dataset.harga);
            let qty = parseInt(tr.querySelector('.qty-input').value);
            let subtotal = harga * qty;
            tr.querySelector('.subtotal-text').textContent = formatRupiah(subtotal);
            hitungTotal();
        }

        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('#keranjangContainer tr').forEach(tr => {
                let jenis = tr.dataset.jenis;
                if (jenis === 'barang') {
                    let harga = parseFloat(tr.dataset.harga);
                    let qty = parseInt(tr.querySelector('.qty-input').value);
                    total += (harga * qty);
                } else if (jenis === 'jasa') {
                    let harga = parseFloat(tr.dataset.harga);
                    total += harga;
                }
            });
            document.getElementById('grandTotalText').textContent = formatRupiah(total);
        }
    </script>
</body>
</html>