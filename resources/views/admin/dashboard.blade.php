@extends('partials.main')

@section('konten')

			<div class="card-box pd-20 height-100-p ">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="{{ asset('assets/vendors/images/admin.png') }}" alt="">
					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Selamat Datang <div class="weight-600 font-30 text-blue">{{ Auth::user()->name }}</div>
						</h4>
						<p class="font-18 max-width-600 text-justify">Sistem Smart Meal membantu Anda merencanakan pola makan sehat dengan menggunakan metode TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution) untuk memilih makanan terbaik berdasarkan kebutuhan kalori harian dan preferensi nutrisi Anda.
Gunakan fitur yang tersedia untuk melihat daftar makanan, rekomendasi menu harian berdasarkan perhitungan TOPSIS, serta memantau perkembangan diet Anda secara optimal.</p>
					</div>
				</div>
			</div>

			<div class="row mt-4">
				<div class="col-6">
					<div class="card card-box mb-3">
						<div class="card-body d-flex align-items-center gap-2">
							<div class="icon">
								<i class="icon-copy fa fa-users mr-5" aria-hidden="true" style="font-size: 50px; color:darkorange;"></i>
							</div>
							<div class="text">
								<p class="card-text">Total User </p>
								<h1 class="card-text text-warning weight-400" style="font-size: 40px;">{{ $usercount }} </h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="card card-box mb-3">
						<div class="card-body d-flex align-items-center gap-2">
							<div class="icon">
								<i class="icon-copy fa fa-cutlery mr-5" aria-hidden="true" style="font-size: 50px; color:rgb(0, 217, 51);"></i>
							</div>
							<div class="text">
								<p class="card-text">Total Makanan </p>
								<h1 class="card-text text-success weight-400" style="font-size: 40px;">{{ $makanan }} </h1>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card shadow mt-4">
				<div class="card-header">
					<h5 class="grafik">Grafik Status BMI Pengguna</h5>
				</div>
				<div class="card-body rounded" style="border-radius: 20px;">
					<canvas id="statusChart" style="max-height: 400px;"></canvas>
				</div>
			</div>

			<!-- Chart.js v4 -->
		<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

		<canvas id="statusChart" height="40"></canvas>

		<script>
			const ctx = document.getElementById('statusChart');

			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: {!! json_encode(array_keys($statusCounts)) !!},
					datasets: [{
						label: 'Jumlah Pengguna',
						data: {!! json_encode(array_values($statusCounts)) !!},
						backgroundColor: [
							'rgba(255, 99, 132, 0.2)', // Kurus
							'rgba(54, 162, 235, 0.2)', // Normal
							'rgba(255, 206, 86, 0.2)', // Overweight
							'rgba(255, 99, 132, 0.2)', // Obesitas I
							'rgba(153, 102, 255, 0.2)' // Obesitas II
						],
						borderColor: [
							'rgba(255, 99, 132, 1)',
							'rgba(54, 162, 235, 1)',
							'rgba(255, 206, 86, 1)',
							'rgba(255, 99, 132, 1)',
							'rgba(153, 102, 255, 1)'
						],
      					// warna tepi
						borderWidth: 2,
						borderRadius: 0,
						// barThickness: 30
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: { display: false },
						title: {
							display: true,
							text: 'Distribusi Status BMI Pengguna'
						}
					},
					scales: {
						y: {
							beginAtZero: true,
							ticks: { precision: 0 }
						}
					}
				}
			});
		</script>






@endsection