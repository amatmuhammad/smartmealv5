<div class="left-side-bar">
		<div class="brand-logo">
			<a href="#">
				<img src="{{ asset('assets/vendors/images/LOGO_SM.png') }}" alt="gambar" width="50px">
				<h2 class="text-white text-center">SMART MEAL</h2>
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
						<ul class="submenu">
							@can('admin')
								<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
							@endcan
							@can('user')
								<li><a href="{{ route('indexuser') }}">Dashboard User</a></li>
							@endcan
						</ul>
					</li>

					@can('user')
					<li>
						<a href="{{ route('riwayat') }}" class="dropdown-toggle no-arrow">
							<span class="micon fa fa-history"></span><span class="mtext">Riwayat Makanan</span>
						</a>
					</li>	
					@endcan
					@can('admin')
						
					<li>
						<a href="{{ route('makanan') }}" class="dropdown-toggle no-arrow">
							<span class="micon fa fa-cutlery"></span><span class="mtext">Alternatif Makanan</span>
						</a>
					</li>
					
					<li>
                        <a href="{{ route('pembobotan') }}" class="dropdown-toggle no-arrow">
                            <span class="micon fa fa-balance-scale"></span><span class="mtext">Pembobotan</span>
                        </a>
                    </li>
                    <li>
						<a href="{{ route('topsis') }}" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-diagram"></span><span class="mtext">Hasil Topsis</span>
						</a>
					</li>
                    <li>
						<a href="{{ route('usermanage') }}" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user"></span><span class="mtext">Manajemen User</span>
						</a>
					</li>
					@endcan

					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<div class="sidebar-small-cap">Auth</div>
					</li>
                    <li>
						<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-toggle no-arrow">
							<span class="micon fa fa-power-off"></span>
							<span class="mtext">Log Out</span>
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>

					</li>
					
				</ul>
			</div>
		</div>
	</div>