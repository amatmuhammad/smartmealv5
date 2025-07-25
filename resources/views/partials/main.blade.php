<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>@yield('judul','Dashboard Admin')</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	<!-- Google Font -->
	
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/core.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/style.css') }}">

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<!-- <div class="loader-logo"><img src="vendors/images/deskapp-logo.svg" alt=""></div> -->
			<h3 class="text-primary">Smart Meal</h3>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
		</div>
		<div class="header-right">
			
			@php
				use App\Models\InfoUser;
			@endphp

			@php
				$info = InfoUser::where('user_id', Auth::id())->first();
			@endphp
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							@if (!$info)								
								<img src="{{ asset('assets/vendors/images/vector user.jpg') }}" alt="">
							@else
								<img src="{{ asset('foto/' . $info->foto) }}" alt="">
							@endif
						</span>
						<span class="user-name">{{ Auth::user()->name }}</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						{{-- <a class="dropdown-item" href="profile.html"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a>
						<a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a> --}}
						<form action="{{ route('logout') }} " method="POST">
							@csrf
							<button type="submit" class="dropdown-item"><i class="dw dw-logout"></i> Log Out</button>
						</form>	
					</div>
				</div>
			</div>
			
		</div>
	</div>

	

	@include('admin.sidebar.sidebar')
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">

			@yield('konten')
            {{-- footer --}}
			@include('partials.footer')
		</div>
	</div>

	{{-- sweet alert --}}
	{{-- <script>
		document.addEventListener('DOMContentLoaded', function () {
			Swal.fire({
				title: 'Selamat Datang!',
				html: 'Sistem <strong>Diet Planner</strong> menggunakan metode <strong>TOPSIS</strong> untuk merekomendasikan menu terbaik berdasarkan kebutuhan kalori dan preferensi nutrisi Anda.',
				icon: 'info',
				confirmButtonText: 'Lanjutkan',
				confirmButtonColor: '#3085d6'
			});
		});
	</script> --}}
	<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Konfirmasi sebelum hapus
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Stop submit dulu

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit jika dikonfirmasi
                    }
                });
            });
        });

        // Flash alert sukses / error
        @if(session('success'))
            Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
        @endif

        @if(session('deleted'))
            Swal.fire('Terhapus!', '{{ session('deleted') }}', 'warning');
        @endif

        @if(session('error'))
            Swal.fire('Gagal!', '{{ session('error') }}', 'error');
        @endif
    });
</script>


	<!-- js -->
	<script src="{{ asset('assets/vendors/scripts/core.js') }}"></script>
	<script src="{{ asset('assets/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('assets/vendors/scripts/layout-settings.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
	{{-- <script src="{{ asset('assets/vendors/scripts/dashboard.js') }}"></script> --}}
	<script src="{{ asset('assets/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('assets/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
	{{-- <script src="{{ asset('asstes/src/plugins/datatables/js/vfs_fonts.js') }}"></script> --}}
	<!-- Datatable Setting js -->
	<script src="{{ asset('assets/vendors/scripts/datatable-setting.js') }}"></script>
</body>
</html>