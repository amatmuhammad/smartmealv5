@extends('partials.main')

@section('judul','Riwayat Menu')

@section('konten')

        <div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Riwayat Makanan</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Riwayat Makanan</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-primary h4">Riwayat Makanan</h4>
						<hr>
					</div>
                    <div class="alert">
                        <div class="alert alert-warning" role="alert">
                            <strong>!!! Harap Memasukkan Data Rekomendasi Makanan Yang Ada pada Dashboard Anda</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="create-data p-3 d-flex justify-content-end">
                                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addRiwayatModal">+ Tambah Riwayat</button>
                            </div>
                        </div>
                    </div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead class="bg-primary text-center text-white">
								<tr>
									<th class="table-plus datatable-nosort">Nama Makanan</th>
									<th>Waktu Makan</th>
									<th>Tanggal</th>
									<th>Kalori</th>
								</tr>
							</thead>
							<tbody class="text-center">
                                 @foreach($riwayat as $item)
                                    <tr>
                                        <td class="table-plus">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $item->waktu_makan)) }}</td>
                                        <td>{{ $item->makanan->nama_makanan }}</td>
                                        <td>{{ $item->makanan->kalori }} kkal</td>
                                    </tr>
                                @endforeach
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->

                <!-- Modal -->
                <div class="modal fade" id="addRiwayatModal" tabindex="-1" aria-labelledby="addRiwayatModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('storeriwayat') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Riwayat Makanan</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <label for="makanan_id">Makanan</label>
                                    <select name="makanan_id" class="form-control" required>
                                        @foreach($rekom as $item)
                                            <option value="{{ $item->makanan->id }}">
                                                {{ $item->makanan->nama_makanan }} ({{ $item->makanan->kalori }} kkal)
                                            </option>
                                        @endforeach
                                    </select>

                                    <label for="waktu_makan" class="mt-3">Waktu Makan</label>
                                    <select name="waktu_makan" class="form-control" required>
                                        <option value="sarapan">Sarapan</option>
                                        <option value="makan_siang">Makan Siang</option>
                                        <option value="snack">Snack</option>
                                        <option value="makan_malam">Makan Malam</option>
                                    </select>

                                    <label for="tanggal" class="mt-3">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" value="{{ now()->toDateString() }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Grafik Kalori Harian -->
                <div class="card">
                    <div class="card-header">Grafik Konsumsi Kalori Harian</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="filter d-flex justify-content-end p-3">
                                <form method="GET" class="form-inline mb-3">
                                    <label for="bulan" class="mr-2">Filter Bulan:</label>
                                    <input type="month" name="bulan" id="bulan" class="form-control mr-2" value="{{ $bulan }}">
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <canvas id="kaloriChart" height="100"></canvas>
                    </div>
                </div>
                <br>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <script>
            const ctx = document.getElementById('kaloriChart').getContext('2d');
            const kaloriChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($kaloriHarian->pluck('tanggal')->map(fn($t) => \Carbon\Carbon::parse($t)->format('d M'))) !!},
                    datasets: [{
                        label: 'Kalori Harian Anda - Bulan {{ \Carbon\Carbon::parse($bulan)->isoFormat("MMMM YYYY") }}',
                        data: {!! json_encode($kaloriHarian->pluck('total_kalori')) !!},
                        borderColor: 'rgb(74, 88, 255)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Kalori (kkal)' }
                        },
                        x: {
                            title: { display: true, text: 'Tanggal' }
                        }
                    }
                }
            });
        </script>

    
@endsection