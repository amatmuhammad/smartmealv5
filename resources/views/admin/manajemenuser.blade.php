@extends('partials.main')

@section('judul','Manajemen User')

@section('konten')

            <div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Manajemen User</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Manajemen User</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-primary h4">Manajemen User</h4>
						<hr>
					</div>
					<div class="table-responsive pb-2">
						<table class="data-table table stripe hover nowrap">
							<thead class="bg-primary text-white text-center">
								<tr>
									<th class="table-plus datatable-nosort">No</th>
									<th>Username</th>
									<th>Email</th>
									<th>Umur</th>
									<th>Tinggi Badan</th>
									<th>Berat Badan</th>
									<th>Status</th>
									<th>Role</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody class="text-center">

									@foreach ($user as $index => $p)
                                    @php
                                        $status = $p->InfoUser->status ?? '-';
                                        $role = $p->is_admin; 
                                        $badgeClass = 'secondary';

                                        if($role === 1){
                                            $roles = 'admin' ;    
                                        }else {
                                            $roles = 'User';
                                        }

                                        switch ($status) {
                                            case 'Kurus':
                                                $badgeClass = 'warning';
                                                break;
                                            case 'Normal':
                                                $badgeClass = 'success';
                                                break;
                                            case 'Overweight':
                                                $badgeClass = 'warning';
                                                break;
                                            case 'Obesitas I':
                                                $badgeClass = 'danger';
                                                break;
                                            case 'Obesitas II':
                                                $badgeClass = 'danger';
                                                break;
                                        }


                                    @endphp
										<tr>
											<td>{{ $index + 1 }}</td>
											<td>{{ $p->name }}</td>
											<td>{{ $p->email }}</td>
											<td>{{ $p->InfoUser->umur ?? '-' }}</td>
                                            <td>{{ $p->InfoUser->tinggi_badan ?? '-' }}</td>
                                            <td>{{ $p->InfoUser->berat_badan ?? '-' }}</td>
                                            <td><span class="badge badge-pill text-white bg-{{ $badgeClass }}">{{ $status }}</td>
											<td>{{ $roles }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                       
                                                        <form action="{{ route('destroyuser', $p->id) }}" method="POST" class="d-inline delete-form">
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
            </div>


@endsection