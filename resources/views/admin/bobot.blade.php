@extends('partials.main')

@section('judul','Data Pembobotan')

@section('konten')

    <div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Data Bobot</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Data Bobot</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-primary h4">Data Bobot</h4>
						<hr>
					</div>
                    <div class="container">
                        <div class="create-data">
                            <div class="row ">
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-primary me-5 mb-4" data-toggle="modal" data-target="#modalTambahBobot">+ Tambah Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead class="bg-primary text-white text-center">
								<tr>
									<th class="table-plus datatable-nosort">Nama Kriteria</th>
									<th>Bobot</th>
									<th>Atribut</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
                                @foreach ($bobots as $item)
                                    
								<tr>
									<td class="table-plus">{{ $item->nama_kriteria }}</td>
									<td>{{ $item->bobot }}</td>
									<td>{{ $item->atribut }}</td>
									
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#modalEditBobot{{ $item->id }}">
                                                    <i class="dw dw-edit2"></i> Edit
                                                </a>
                                                <form action="{{ route('destroybobot', $item->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left;">
                                                        <i class="dw dw-delete-3"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
										</div>
									</td>
								</tr>
								
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->

            <!-- Modal tambah data-->
            <div class="modal fade" id="modalTambahBobot" tabindex="-1" aria-labelledby="modalTambahBobotLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('createbobot') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahBobotLabel">Tambah Bobot Kriteria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                            <input type="text" class="form-control" name="nama_kriteria" placeholder="Masukkan kriteria" required>
                        </div>
                        <div class="mb-3">
                            <label for="bobot" class="form-label">Bobot</label>
                            <input type="number" step="0.01" class="form-control" name="bobot" placeholder="Masukkan Bobot" required>
                        </div>
                        <div class="mb-3">
                            <label for="atribut" class="form-label">Tipe Kriteria</label>
                            <select class="form-control" name="atribut" required>
                            <option value="">-- Pilih Atribut --</option>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                            </select>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- Modal Tambah -->
			
            

            <!-- Modal Edit -->
            @foreach ($bobots as $item)
                <!-- Modal Edit -->
                <div class="modal fade" id="modalEditBobot{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditBobotLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('updatebobot', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="modalEditBobotLabel{{ $item->id }}">Edit Bobot Kriteria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                            <input type="text" class="form-control" name="nama_kriteria" value="{{ $item->nama_kriteria }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="bobot" class="form-label">Bobot</label>
                            <input type="number" step="0.01" class="form-control" name="bobot" value="{{ $item->bobot }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="atribut" class="form-label">Tipe Kriteria</label>
                            <select class="form-control" name="atribut" required>
                            <option value="benefit" {{ $item->atribut == 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ $item->atribut == 'cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            @endforeach
            {{-- end edit --}}				
    </div>


@endsection