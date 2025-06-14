@extends('layouts.app')

@section('content')

<title>Profil</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .profile-content {
        background-color: #ffffff;
        padding: 20px;
    }

    .profile-info strong {
        display: block;
        margin-bottom: 5px;
    }

    .profile-sidebar h4 {
        margin: 20px;
        text-align: center;
        font-weight: 650;


    }
    /* Style untuk tab aktif */
    .tab-menu .nav-link.active {
        background-color: #f1f1f1;
        color: black;
    }

    .tab-content {
        margin-top: 20px;
    }

    /* Styling untuk tombol ubah profil */
    .btn-update-profile {
        background-color: black;
        color: white;
    }

    .btn-update-profile:hover {
        background-color: #444;
    }

    .booking {
        font-weight: 600;
        text-decoration: none;
        color: #000;
    }

    

.large-icon {
    font-size: 1.5rem;
}

.tab-menu .nav-link {
    color: black !important;
}

.tab-menu .nav-link.active {
    background-color: #f1f1f1;
    color: black !important;
    font-weight: bold;
}

.tab-menu .nav-link:hover {
    color: black !important;
}

/* Style untuk container utama */
.container {
    max-width: 1200px;
}


.profile-content {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    border: 2px solid #dee2e6;
}

/* Menjaga kolom kanan (konten) agar sejajar dengan kolom kiri */
.row {
    display: flex;
    justify-content: space-between;
}

.col-md-4 {
    flex: 0 0 40%;
}

.col-md-8 {
    flex: 0 0 60%;
}
.informasi {
    margin-left: 10px;
    font-weight: 700;
    font-size: 20px;
}
/* Styling untuk foto profil */
.border-foto {
    border: 5px solid black; /* Border luar orange */
    width: 300px;  /* Edit lebar gambar di sini */
    height: 350px; /* Edit tinggi gambar di sini */
    object-fit: cover; /* Memastikan gambar tidak terdistorsi */
    display: block; /* Agar gambar tidak menyentuh teks di sebelahnya */
    margin: 0 auto; /* Center gambar */
    position: relative; /* Untuk menempatkan pseudo-element */
}

.border-foto::before {
    content: ''; /* Membuat elemen kosong */
    position: absolute;
    top: -6px; /* Sesuaikan jarak top untuk memberikan ruang antara border luar dan dalam */
    left: -6px; /* Sesuaikan jarak kiri */
    right: -6px; /* Sesuaikan jarak kanan */
    bottom: -6px; /* Sesuaikan jarak bawah */
    border: 2px solid black; /* Border dalam hitam */

}

/* Contoh untuk mengubah ukuran gambar secara responsif jika diperlukan */
/* Tambahkan media query untuk layar kecil */
@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }

    .col-md-4, .col-md-8 {
        flex: 100%;
        max-width: 100%;
    }

    .border-foto {
        width: 100%; 
        height: auto; 
        max-height: 250px;
    }

    .nav-link {
        font-size: 14px;
    }

    .large-icon {
        font-size: 1.2rem;
    }

    .profile-sidebar h4 {
        font-size: 18px;
    }

    .profile-info p {
        font-size: 14px;
    }

    .tab-content h3, .tab-content h5 {
        font-size: 18px;
    }

    .card {
        padding: 1rem !important;
        font-size: 14px;
    }
}


.menunggu {
    text-decoration: none;

}

</style>
<div class="container mt-4">
    <div class="row">
        <?php
        $name = Session::get('user_data')['name'];
        $name_parts = explode(' ', $name);
        $first_name = $name_parts[0];
        $last_name = end($name_parts);
        $nama_pendek = $first_name . ' ' . $last_name;
        ?>
        
        <!-- Sidebar kiri (40%) -->
        <div class="col-md-4 profile-sidebar">
            <div style=" border: 2px solid #000; border-radius: 8px; ">
                <div>
                <h4 class="profile-sidebar"> {{ $nama_pendek }}</h4></div>
                <hr>
                <label class="informasi">Akun Saya</label>
                <hr>
                <!-- Tab Menu -->
               <div class="nav flex-column nav-pills tab-menu" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                        <i class="bi bi-person profile-icon large-icon"></i> Profil
                    </a>
                    <a class="nav-link" id="v-pills-edit-profile-tab" data-bs-toggle="pill" href="#v-pills-edit-profile" role="tab" aria-controls="v-pills-edit-profile" aria-selected="false">
                        <i class="bi bi-pencil-square large-icon"></i> Edit Profil
                    </a>
                    <hr>
                    <a class="nav-link" id="v-pills-sedang-berlangsung-tab" data-bs-toggle="pill" href="#v-pills-sedang-berlangsung" role="tab" aria-controls="v-pills-sedang-berlangsung" aria-selected="false">
                        <i class="bi bi-arrow-repeat large-icon"></i> Sedang Berlangsung
                    </a>
                    <a class="nav-link" id="v-pills-riwayat-tab" data-bs-toggle="pill" href="#v-pills-riwayat" role="tab" aria-controls="v-pills-riwayat" aria-selected="false">
                        <i class="bi bi-check-circle large-icon"></i> Riwayat Selesai
                    </a>
               </div>
            </div>
        </div>

        <!-- Konten kanan (60%) -->
        <div class="col-md-8">
            <div class="" >
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Profil Tab -->
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <h3>Profil</h3>
                        <div class="row align-items-center">
                            <!-- Informasi Profil (kiri) -->
                            <div class="col-md-8">
                                <div class="profile-info mb-3">
                                    <strong>Nama Lengkap</strong>
                                    <p>{{ Session::get('user_data')['name'] ?? 'John Doe' }}</p>
                                </div>
                                <div class="profile-info mb-3">
                                    <strong>Nomor Telepon</strong>
                                    <p>
                                        @php
                                            $nomor_telepon = Session::get('user_data')['nomor_telepon'] ?? '6281234567890';
                                            if (substr($nomor_telepon, 0, 2) === '62') {
                                                $nomor_telepon = '0' . substr($nomor_telepon, 2);
                                            }
                                            echo $nomor_telepon;
                                        @endphp
                                    </p>
                                </div>
                                <div class="profile-info mb-3">
                                    <strong>Email</strong>
                                    <p>{{ Session::get('user_data')['email'] }}</p>
                                </div>
                            </div>
                            <!-- Foto Profil (kanan) -->
                            <div class="col-md-4 text-center">
                                <img src="{{ Session::get('user_data')['foto'] ?? 'https://via.placeholder.com/120' }}" alt="Foto Profil" class="img-fluid border-foto">
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profil Tab -->
                    <div class="tab-pane fade" id="v-pills-edit-profile" role="tabpanel" aria-labelledby="v-pills-edit-profile-tab">
                        <h5>Edit Profil</h5>

                        <form id="updateProfileForm" action="{{ route('profil.update') }}" method="POST">

                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Session::get('user_data')['name'] ?? '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="{{ Session::get('user_data')['nomor_telepon'] ?? '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Session::get('user_data')['email'] ?? '' }}">
                            </div>

                            {{-- Optional: Tambahkan field URL jika kamu punya upload/URL foto --}}
                            {{-- <input type="hidden" name="url" value="https://example.com/gambar.jpg"> --}}

                            <button type="submit" class="btn btn-update-profile">Ubah Profil</button>
                        </form>
                    </div>

                <!-- Sedang berlangsung Tab -->    
                <div class="tab-pane fade" id="v-pills-sedang-berlangsung" role="tabpanel" aria-labelledby="v-pills-sedang-berlangsung-tab">
                    @if(!empty($sedang) && count($sedang) > 0)
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            @foreach($sedang as $index => $item)
                                @php
                                    $pemesanan = $item['pemesanan'];
                                    $transaksi = $item['transaksi'];
                                    $statusPemesanan = strtolower($pemesanan['status_pemesanan']);
                                    $statusPembayaran = strtolower($transaksi['status_pembayaran']);
                                    $deadline = $transaksi['deadline_pembayaran'] ?? null;

                                    $shouldShow = $statusPemesanan === 'sedang dipesan' && $statusPembayaran === 'menunggu';

                                    $jadwalList = collect($pemesanan['jadwal_dipesan'])->sortBy('jam');
                                    $jamList = $jadwalList->pluck('jam')->map(fn($j) => (int) $j)->values();
                                    $jamMulai = $jamList->min();
                                    $jamSelesai = $jamList->max() + 1;
                                    $tanggal = $jadwalList->first()['tanggal'];
                                    $lapangan = $jadwalList->first()['lapangan']['name'] ?? '-';
                                    $metode = strtoupper(str_replace('_', ' ', $transaksi['metode_pembayaran']));
                                @endphp

                                @if($shouldShow)
                                    <div class="col">
                                        @php
                                            $encoded = base64_encode(json_encode($item));
                                        @endphp
                                       <a href="{{ route('profil.detailStatus', ['data' => $encoded]) }}" class="text-decoration-none">
                                            <div class="card shadow-sm p-4 position-relative" style="min-height: 250px; transition: transform 0.3s ease;">
                                                {{-- Countdown - pojok kanan atas --}}
                                                @if($deadline)
                                                    <div class="position-absolute top-0 end-0 m-2">
                                                        <span class="badge bg-danger text-white" id="countdown-{{ $index }}">--:--</span>
                                                    </div>
                                                @endif

                                                {{-- Konten utama --}}
                                                <div class="mt-2 mb-3">
                                                    <strong>{{ $lapangan }}</strong><br>
                                                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}<br>
                                                    {{ str_pad($jamMulai, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($jamSelesai, 2, '0', STR_PAD_LEFT) }}:00
                                                    <div class="mt-3">
                                                        <p class="mb-1">Jumlah Pesanan: {{ count($pemesanan['jadwal_dipesan']) }}</p>
                                                        <p class="mb-0">Metode Pembayaran: {{ $metode }}</p>
                                                    </div>
                                                </div>

                                                {{-- Menunggu - pojok kanan bawah --}}
                                                <div class="position-absolute bottom-0 end-0 m-2">
                                                    <span class="badge rounded bg-warning text-dark px-4 py-2">Menunggu</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    {{-- JS Countdown --}}
                                    @if($deadline)
                                        <script>
                                            (() => {
                                                const countdownEl = document.getElementById("countdown-{{ $index }}");
                                                const deadline = new Date("{{ \Carbon\Carbon::parse($deadline)->toIso8601String() }}").getTime();

                                                function updateCountdown() {
                                                    const now = new Date().getTime();
                                                    let timeLeft = Math.floor((deadline - now) / 1000);

                                                    if (timeLeft <= 0) {
                                                        countdownEl.innerText = "00:00";
                                                        return;
                                                    }

                                                    const minutes = Math.floor(timeLeft / 60);
                                                    const seconds = timeLeft % 60;
                                                    countdownEl.innerText =
                                                        ('0' + minutes).slice(-2) + ":" + ('0' + seconds).slice(-2);

                                                    requestAnimationFrame(updateCountdown);
                                                }

                                                updateCountdown();
                                            })();
                                        </script>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p>Tidak ada booking yang sedang berlangsung.</p>
                    @endif
                </div>

                <!-- Riwayat Selesai Tab -->    
<div class="tab-pane fade" id="v-pills-riwayat" role="tabpanel" aria-labelledby="v-pills-riwayat-tab">
    @if(!empty($riwayat) && count($riwayat) > 0)
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($riwayat as $item)
                @php
                    $pemesanan = $item['pemesanan'];
                    $transaksi = $item['transaksi'];
                    $status = strtolower($item['status']);

                    if (!in_array($status, ['berhasil', 'ditolak', 'dibatalkan','terlambat'])) continue;

                    $jadwalList = collect($pemesanan['jadwal_dipesan'])->sortBy('jam');
                    $jamList = $jadwalList->pluck('jam')->map(fn($j) => (int) $j)->values();
                    $jamMulai = $jamList->min();
                    $jamSelesai = $jamList->max() + 1;
                    $tanggal = $jadwalList->first()['tanggal'];
                    $lapangan = $jadwalList->first()['lapangan']['name'] ?? '-';
                    $metode = strtoupper(str_replace('_', ' ', $transaksi['metode_pembayaran']));

                    // Badge warna
                    $badgeClass = match($status) {
                        'berhasil' => 'bg-success text-white',
                        'ditolak' => 'bg-danger text-white',
                        'dibatalkan' => 'bg-danger text-white',
                        'terlambat' => 'bg-secondary text-white',
                        default => 'bg-dark text-white'
                    };
                @endphp

                <div class="col riwayat-item">
                     @php
                                            $encoded = base64_encode(json_encode($item));
                                        @endphp
                                       <a href="{{ route('profil.detailStatus', ['data' => $encoded]) }}" class="text-decoration-none">
                        <div class="card shadow-sm p-4 position-relative" style="min-height: 250px;">
                            {{-- Info --}}
                            <div class="mt-2 mb-3">
                                <strong>{{ $lapangan }}</strong><br>
                                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}<br>
                                {{ str_pad($jamMulai, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($jamSelesai, 2, '0', STR_PAD_LEFT) }}:00
                                <div class="mt-3">
                                    <p class="mb-1">Jumlah Pesanan: {{ count($pemesanan['jadwal_dipesan']) }}</p>
                                    <p class="mb-0">Metode Pembayaran: {{ $metode }}</p>
                                </div>
                            </div>

                            {{-- Status Badge --}}
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <span class="badge rounded {{ $badgeClass }} px-4 py-2 text-capitalize">{{ $status }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        {{-- Pagination controls --}}
        @if(count($riwayat) > 4)
            <nav aria-label="Page navigation riwayat">
                <ul class="pagination justify-content-center" id="pagination-riwayat">
                    <!-- JS yg generate tombol pagination -->
                </ul>
            </nav>
        @endif
    @else
        <p>Tidak ada riwayat pemesanan.</p>
    @endif
</div>

                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 15%; "></div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

<script>
      document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('updateProfileForm');

        // Event listener untuk form submit
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Menghentikan pengiriman form secara langsung

            // Menampilkan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin ingin mengganti profil?',
                text: "Periksa kembali data Anda sebelum mengubah profil.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ganti Profil!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna memilih 'Ya, Ganti Profil!'
                    form.submit(); // Kirim form setelah konfirmasi
                }
            });
        });
    });

document.addEventListener('DOMContentLoaded', function () {
    const itemsPerPage = 4;

    function setupPagination(itemsSelector, paginationId) {
        const items = document.querySelectorAll(itemsSelector);
        const pageCount = Math.ceil(items.length / itemsPerPage);
        const pagination = document.getElementById(paginationId);

        if (pageCount <= 1) {
            // Kalau cuma 1 halaman atau kurang, sembunyikan pagination
            if (pagination) pagination.style.display = 'none';
            return;
        }

        // Hapus isi pagination sebelumnya kalau ada
        pagination.innerHTML = '';

        function showPage(page) {
            items.forEach((item, index) => {
                item.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'block' : 'none';
            });
            [...pagination.children].forEach(li => li.classList.remove('active'));
            pagination.children[page - 1].classList.add('active');
        }

        // Buat tombol halaman
        for(let i = 1; i <= pageCount; i++) {
            const li = document.createElement('li');
            li.className = 'page-item' + (i === 1 ? ' active' : '');
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.innerText = i;
            a.addEventListener('click', (e) => {
                e.preventDefault();
                showPage(i);
            });
            li.appendChild(a);
            pagination.appendChild(li);
        }

        showPage(1);
    }

    // Panggil pagination untuk Sedang Berlangsung dan Riwayat
    setupPagination('#v-pills-sedang-berlangsung .sedang-item', 'pagination-sedang');
    setupPagination('#v-pills-riwayat .riwayat-item', 'pagination-riwayat');
});
</script>

@endsection
