@extends('partials.main')

@section('judul','Hasil Topsis')

@section('konten')

			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Hasil Topsis</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Hasil Topsis</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-primary h4">Hasil Topsis</h4>
						<hr>
					</div>
					<div class="table-responsive pb-2">
						<table class="data-table table stripe hover nowrap ">
							<thead class="bg-primary text-white text-center">
								<tr>
									<th class="table-plus datatable-nosort">Peringkat</th>
									<th>Nama Makanan</th>
									<th>Nilai D+</th>
									<th>Nilai D-</th>
									<th>Nilai Preferensi (V)</th>
								</tr>
							</thead>
							<tbody class="text-center">

									@foreach ($hasil as $item)
										<tr>
											<td>{{ $item['ranking'] }}</td>
											<td>{{ $item['nama_makanan'] }}</td>
											<td>{{ $item['d_plus'] }}</td>
											<td>{{ $item['d_minus'] }}</td>
											<td>{{ $item['nilai_preferensi'] }}</td>
											
										</tr>
									@endforeach

									
								
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
			</div>


@endsection