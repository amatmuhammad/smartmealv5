@extends('partials.main')

@section('judul','Data Makanan')

@section('konten')

            <div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Data Makanan</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Data Makanan</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-primary h4">Data Makanan</h4>
						<hr>
					</div>
                    
                    <div class="row ">
                        <div class="col-12 ">
                            <div class="create-data p-3 d-flex justify-content-end">
                                <button class="btn btn-primary mb-4 " data-toggle="modal" data-target="#modalTambahMakanan">
                                    + Tambah Data
                                </button>
                                <button class="btn btn-success mb-4 ml-2" data-toggle="modal" data-target="#modalUploadExcel">
                                    📄 Upload Excel
                                </button>
                            </div>
                            <!-- Tombol Upload Excel -->
                            
                        </div>
                    </div>
					<div class="table-responsive pb-2">
						<table class="data-table table stripe hover nowrap">
							<thead class="bg-primary text-white text-center">
								<tr>
									<th class="table-plus datatable-nosort">Nama Makanan</th>
									<th>Kalori</th>
									<th>Serat</th>
									<th>Lemak</th>
									<th>protein</th>
									<th>Gambar</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>
                                @foreach ($makan as $item)
                                    
								<tr>
									<td class="table-plus">{{ $item->nama_makanan }}</td>
									<td>{{ $item->kalori }} <span class="badge badge-pill badge-warning">kkal</span></td>
									<td>{{ $item->serat }} <span class="badge badge-pill badge-warning">(gram)</span></td>
									<td>{{ $item->lemak }} <span class="badge badge-pill badge-warning">(gram)</span></td>
									<td>{{ $item->protein }} <span class="badge badge-pill badge-warning">(gram)</span></td>
									<td>
                                        <img src="{{ asset('images/'.$item->gambar) }}" alt="gambar" width="80">
                                    </td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#modalEdit{{ $item->id }}">
                                                    <i class="dw dw-edit2"></i> Edit
                                                </a>
                                                <form action="{{ route('destroymakanan', $item->id) }}" method="POST" class="d-inline delete-form">
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
                <div class="modal fade" id="modalTambahMakanan" tabindex="-1" aria-labelledby="modalTambahMakananLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('storemakanan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahMakananLabel">Tambah Makanan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama Makanan</label>
                                <input type="text" name="nama_makanan" class="form-control" placeholder="Masukkan Nama Makanan" required>
                            </div>
                            <div class="mb-3">
                                <label>Kalori</label>
                                <input type="number" name="kalori" step="0.01" class="form-control" placeholder="Masukkan Jumlah Kalori" required>
                            </div>
                            <div class="mb-3">
                                <label>Serat</label>
                                <input type="number" name="serat" step="0.01" class="form-control" placeholder="Masukkan Jumlah Serat" required>
                            </div>
                            <div class="mb-3">
                                <label>Lemak</label>
                                <input type="number" name="lemak" step="0.01" class="form-control" placeholder="Masukkan Jumlah Lemak" required>
                            </div>
                            <div class="mb-3">
                                <label>Protein</label>
                                <input type="number" name="protein" step="0.01" class="form-control" placeholder="Masukkan Jumlah Protein" required>
                            </div>
                            <div class="mb-3">
                                <label>Gambar</label>
                                <input type="file" name="gambar" class="form-control" >
                            </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>				
                {{-- modal edit data --}}

                <!-- Modal Edit -->
                @foreach ($makan as $item)
                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('updatemakanan', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Edit Makanan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama Makanan</label>
                                    <input type="text" name="nama_makanan" class="form-control" value="{{ $item->nama_makanan }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Kalori</label>
                                    <input type="number" step="0.01" name="kalori" class="form-control" value="{{ $item->kalori }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Serat</label>
                                    <input type="number" step="0.01" name="serat" class="form-control" value="{{ $item->serat }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Lemak</label>
                                    <input type="number" step="0.01" name="lemak" class="form-control" value="{{ $item->lemak }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Protein</label>
                                    <input type="number" step="0.01" name="protein" class="form-control" value="{{ $item->protein }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Ganti Gambar (opsional)</label>
                                    <input type="file" name="gambar" class="form-control">
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Perbarui</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                @endforeach
                {{-- end edit --}}

                <!-- Modal Upload Excel -->
                <div class="modal fade" id="modalUploadExcel" tabindex="-1" role="dialog" aria-labelledby="modalUploadExcelLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="modalUploadExcelLabel">Upload Excel Makanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="excel_file">Pilih File Excel (.xlsx)</label>
                                <input type="file" class="form-control" name="excel_file" accept=".xls,.xlsx" required>
                                <small class="text-danger">Jangan Menggunakan File .CSV</small>
                            </div>
                        </div>
                            <a href="{{ asset('format_excel_smartmeal.xlsx') }}" class="text-success mb-3 text-center">Unduh Template Excel Disini</a>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
				
				
            </div>



@endsection