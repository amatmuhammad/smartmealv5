@extends('partials.main')

@section('judul', 'Dashboard User')

@section('konten')



			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Dashboard User</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Dashboard User</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">
							<div class="profile-photo">
								@if (!$info)
									<img src="{{ asset('assets/vendors/images/vector user.jpg') }}" alt="Foto" class="avatar-photo shadow-lg p-1 mb-2">
								@else
									<img src="{{ asset('foto/' . $info->foto) }}" alt="Foto" class="avatar-photo shadow-lg p-1 mb-2">
								@endif
								
							</div>
							<h5 class="text-center h5 mt-4 mb-0">{{ Auth::User()->name }}</h5>
							<p class="text-center text-muted font-14"></p>
							<div class="profile-info">
								<h5 class="mb-20 h5 text-blue">Informasi User</h5>
								<ul>
									<li>
										<span>Username:</span>
										{{ Auth::User()->name }}
									</li>
									<li>
										<span>Email Address:</span>
										{{ Auth::user()->email }}
									</li>
									@if (!$info)
										<li>
											<span>Umur:</span>
											Lengkapi Data
										</li>
										<li>
											<span>Tinggi Badan (Cm):</span>
											Lengkapi Data
										</li>
										<li>
											<span>Berat Badan (Kg) :</span>
											Lengkapi Data
										</li>
										<li>
											<span>Kalori Harian (Kkal) :</span>
											Lengkapi Data
										</li>
										<li>
											<span>Status (Kkal) :</span>
											Lengkapi Data
										</li>
									@else
										<li>
											<span>Umur:</span>
											{{ $info->umur }} Tahun
										</li>
										<li>
											<span>Tinggi Badan (Cm):</span>
											{{ $info->tinggi_badan }}
										</li>
										<li>
											<span>Berat Badan (Kg) :</span>
											{{ $info->berat_badan }}
										</li>
										<li>
											<span>Kalori Harian (Kkal) :</span>
											{{ $info->kalori_harian }}
										</li>
										<li>
											<span>Status (Kkal) :</span>
											{{ $info->status }}
										</li>
									@endif
								</ul>
							</div>
							<div class="button mt-5">
								@if (!$info)
									<button class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahDataModal">Tambah Data Diri</button>
										<!-- Modal Tambah -->
									<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
										<div class="modal-dialog">
											<form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
											@csrf
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Tambah Data Diri</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<label>Umur:</label>
													<input type="number" name="umur" class="form-control mb-4" placeholder="Masukkan Umur Anda" required>

													<label>Tinggi Badan (cm):</label>
													<input type="number" name="tinggi_badan" class="form-control mb-4" placeholder="Masukkan Tinggi Badan" required>

													<label>Berat Badan (kg):</label>
													<input type="number" name="berat_badan" class="form-control mb-4" placeholder="Masukkan Berat Badan" required>

													<label>Foto (opsional):</label>
													<input type="file" name="foto" class="form-control">
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary">Simpan</button>
												</div>
											</div>
											</form>
										</div>
									</div>
								@else
									{{-- <button class="btn btn-outline-warning" data-toggle="modal" data-target="#editFotoModal{{ $info->id }}">Update Foto</button> --}}
										<!-- Modal Update -->
									<div class="modal fade" id="editFotoModal{{ $info->id }}" tabindex="-1">
										<div class="modal-dialog">
											<form action="{{ route('update', $info->id) }}" method="POST" enctype="multipart/form-data">
											@csrf
											{{-- @method('PUT') --}}
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Update Foto</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<label>Ganti Foto:</label>
													<input type="file" name="foto" class="form-control" accept="image/*">
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-warning">Update</button>
												</div>
											</div>
											</form>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
						<div class="card-box height-100-p overflow-hidden">
							<div class="profile-tab height-100-p">
								<div class="tab height-100-p">
									<ul class="nav nav-tabs customtab" role="tablist">
										
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Timeline</a>
										</li>
									</ul>
									<div class="tab-content">
										@if (!$info)
										<div class="alert-data">
											<div class="alert alert-warning mt-2">
												Silakan lengkapi data diri Anda terlebih dahulu untuk mendapatkan rekomendasi makanan.
											</div>
										</div>
										@else
										<div class="alert alert-success mt-3">
											Kebutuhan kalori harian Anda: <strong>{{ $userKalori }} kkal</strong>
										</div>
										<div class="alert alert-info">
											Kalori yang Anda konsumsi hari ini: <strong>{{ $kaloriHariIni }} kcal</strong>
										</div>

										@if (count($alertHari) > 0)
											<div class="alert">
												<div class="alert alert-danger">
													<strong>Peringatan!</strong> Anda melebihi batas kalori harian pada:
													<ul>
														@foreach ($alertHari as $alert)
															<li>
																Tanggal: {{ \Carbon\Carbon::parse($alert['tanggal'])->format('d M Y') }} —
																Total: {{ $alert['total_kalori'] }} kkal
															</li>
														@endforeach
													</ul>
												</div>
											</div>
										@endif

											@foreach ($rekomendasi as $waktu => $items)
												<div class="tab-pane fade show active" id="timeline" role="tabpanel">
													<div class="pd-10">
														<div class="profile-timeline">
															<div class="timeline-month">
																<h5>
																	Rekomendasi Makanan untuk {{ ucfirst(str_replace('_', ' ', $waktu)) }}
																	<br>
																	 <small>Kebutuhan kalori: <strong>{{ $kaloriPerwaktu[$waktu] }} kkal</strong></small>
																</h5>
															</div>
															<div class="profile-timeline-list">
																<ul>
																	@forelse($items as $item)
																		<li>
																			<div class="date">{{ now()->format('d M') }}</div>
																			<div class="task-name">
																				<i class="ion-android-restaurant"></i> {{ $item->makanan->nama_makanan }}
																			</div>
																			<p>
																				Kalori: {{ $item->makanan->kalori }} kkal<br>
																				Protein: {{ $item->makanan->protein }} g<br>
																				Lemak: {{ $item->makanan->lemak }} g<br>
																				Serat: {{ $item->makanan->serat }} g
																			</p>
																			<div class="task-time">
																				Preferensi: {{ number_format($item->nilai_preferensi, 4) }}
																			</div>
																		</li>
																	@empty
																		<li>
																			<div class="date">{{ now()->format('d M') }}</div>
																			<div class="task-name"><i class="ion-alert-circled"></i> Tidak ada rekomendasi</div>
																			<p>Tidak ditemukan makanan yang sesuai kebutuhan kalori Anda.</p>
																		</li>
																	@endforelse
																</ul>
															</div>
														</div>
													</div>
												</div>
											@endforeach
										@endif
									


								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			


			




@endsection