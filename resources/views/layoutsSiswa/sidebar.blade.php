<nav id="mainnav-container">
	<div id="mainnav">


		<!--OPTIONAL : ADD YOUR LOGO TO THE NAVIGATION-->
		<!--It will only appear on small screen devices.-->
		<!--================================
		<div class="mainnav-brand">
			<a href="index.html" class="brand">
				<img src="img/logo.png" alt="Nifty Logo" class="brand-icon">
				<span class="brand-text">Nifty</span>
			</a>
			<a href="#" class="mainnav-toggle"><i class="pci-cross pci-circle icon-lg"></i></a>
		</div>
		-->



		<!--Menu-->
		<!--================================-->
		<div id="mainnav-menu-wrap">
			<div class="nano">
				<div class="nano-content">

					<!--Profile Widget-->
					<!--================================-->
					<div id="mainnav-profile" class="mainnav-profile">
						<div class="profile-wrap text-center">
							<div class="pad-btm">
								@auth('siswa')
									@if(Auth::guard('siswa')->user()->foto_siswa)
										<img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ asset('storage/photos/'.basename(Auth::guard('siswa')->user()->foto_siswa)) }}" alt="Siswa Photo">
									@else
										<!-- Tampilkan gambar default jika tidak ada foto profil siswa -->
										<img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ asset('assets/img/default-siswa-photo.png') }}" alt="Siswa Photo">
									@endif
								@endauth
							</div>
							<a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
								@auth('siswa')
									@if (Auth::guard('siswa')->user()->nama_siswa)
										<p class="mnp-name">{{ Auth::guard('siswa')->user()->nama_siswa }}</p>
									@else
										<p class="mnp-name">Nurul</p>
									@endif
								@endauth
							</a>
						</div>
					</div>
					<ul id="mainnav-menu" class="list-group">
			
						
						{{-- <li class="list-header">Navigation</li> --}}
			
						
						<li class="{{ request()->is('siswa/home*') ? 'active-sub' : '' }}">
							<a href="{{ route('siswa.home') }}">
								<i class="demo-pli-home"></i>
								<span class="menu-title">Dashboard</span>
							</a>
						</li>
						<li class="{{ request()->is('siswa/jadwal*') ? 'active-sub' : '' }}">
							<a href={{ route('jadwal.index') }}>
								<i class="far fa-clock"></i>
								<span class="menu-title">Jadwal</span>
								{{-- <i class="arrow"></i> --}}
							</a>

								{{-- <ul class="collapse {{ request()->is('admin/home*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/home*') ? 'active-link' : '' }}"><a href="{{ route('admin.home') }}">Jadwal</a></li>
								</ul> --}}
						</li>
						<li class="{{ request()->is('siswa/nilai*') ? 'active-sub' : '' }}">
							<a href="{{ route('nilai.index') }}">
								<i class="fas fa-chart-bar"></i>
								<span class="menu-title">Nilai</span>
							</a>
						</li>
						<li class="{{ request()->is('siswa/absensi*') ? 'active-sub' : '' }}">
							<a href="#">
								<i class="fas fa-user"></i>
								<span class="menu-title">Absensi</span>
								<i class="arrow"></i>
							</a>

								<ul class="collapse {{ request()->is('admin/home*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/home*') ? 'active-link' : '' }}"><a href="{{ route('admin.home') }}">Absensi</a></li>
								</ul>
						</li>

						{{-- <li class="{{ request()->is('admin/role*','admin/user*') ? 'active-sub' : '' }}">
							<a href="#">
								<i class="fas fa-user"></i>
								<span class="menu-title">Master User</span>
								<i class="arrow"></i>
							</a>

								
								<ul class="collapse {{ request()->is('admin/role*', 'admin/user*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/role*') ? 'active-link' : '' }}"><a href="{{ route('role.index') }}">Role</a></li>
									<li class="{{ request()->is('admin/user*') ? 'active-link' : '' }}"><a href="{{ route('user.index') }}">User</a></li>
								</ul>
						</li>

							
							<li class="{{ request()->is('admin/menu*') ? 'active-sub' : '' }}">
								<a href="#">
									<i class="demo-pli-folder"></i>
									<span class="menu-title">Master Menu</span>
									<i class="arrow"></i>
								</a>
							
								
								<ul class="collapse {{ request()->is('admin/menu*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/menu') ? 'active-link' : '' }}"><a href="{{ route('menu.index') }}">Menu</a></li>
								</ul>
							</li>

							<li class="{{ request()->is('admin/transaksi*','admin/jasa*','admin/kategori*','admin/aditional*','admin/toko*', 'admin/customer*', 'admin/cabang*') ? 'active-sub' : '' }}">
								<a href="#">
									<i class="fas fa-tshirt"></i> 
									<span class="menu-title">Laundry</span>
									<i class="arrow"></i>
								</a>

								

								<ul class="collapse {{ request()->is('admin/transaksi*', 'admin/kategori*', 'admin/toko*', 'admin/customer*', 'admin/cabang*', 'admin/jasa*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/transaksi*') ? 'active-link' : '' }}"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
									
									<li class="{{ request()->is('admin/jasa*') ? 'active-link' : '' }}"><a href="{{ route('jasa.index') }}">Jasa</a></li>
									<li class="{{ request()->is('admin/kategori*') ? 'active-link' : '' }}"><a href="{{ route('kategori.index') }}">Kategori</a></li>
									<li class="{{ request()->is('admin/toko*') ? 'active-link' : '' }}"><a href="{{ route('toko.index') }}">Toko</a></li>
									<li class="{{ request()->is('admin/customer*') ? 'active-link' : '' }}"><a href="{{ route('customer.index') }}">Customer</a></li>
									<li class="{{ request()->is('admin/cabang*') ? 'active-link' : '' }}"><a href="{{ route('cabang.index') }}">Cabang</a></li>
									
								</ul>
							</li>

							<li class="{{ request()->is('admin/laporan/transaksi*', 'admin/laporan/jasa*') ? 'active-sub' : '' }}">
								<a href="#">
									<i class="fas fa-file"></i>
									<span class="menu-title">Laporan</span>
									<i class="arrow"></i>
								</a>
	

									<ul class="collapse {{ request()->is('admin/laporan/jasa*', 'admin/laporan/transaksi*') ? 'in' : '' }}">
										
										<li class="{{ request()->is('admin/laporan/jasa*') ? 'active-link' : '' }}"><a href="{{ route('laporan.laporanJasa') }}">Jasa</a></li>
										<li class="{{ request()->is('admin/laporan/transaksi*') ? 'active-link' : '' }}"><a href="{{ route('laporan.laporanTransaksi') }}">Transaksi</a></li>
									</ul>
							</li>

							<li class="{{ request()->is('admin/aksescabang*') ? 'active-sub' : '' }}">
								<a href="#">
									<i class="fas fa-building"></i>
									<span class="menu-title">Akses Cabang</span>
									<i class="arrow"></i>
								</a>
	
									<ul class="collapse {{ request()->is('admin/aksescabang*') ? 'in' : '' }}">
										<li class="{{ request()->is('admin/aksescabang*') ? 'active-link' : '' }}"><a href="{{ route('aksescabang.index') }}">Akses Cabang</a></li>
									</ul>
							</li> --}}

							{{-- <hr> 
							@php
								$iconsByMenuName = [
									'Home' => 'fas fa-home',
									'Master User' => 'fas fa-user',
									'Master Menu' => 'fas fa-folder',
									'Data Sekolah' => 'fas fa-school',
									'Data Kelas' => 'fas fa-chalkboard',
									'Data Mata Pelajaran' => 'fas fa-book',
									'Data Siswa' => 'fas fa-users',
									'Data Kenaikan Kelas' => 'fas fa-graduation-cap',
									'Data Nilai' => 'fas fa-chart-bar',
									'Data Absensi' => 'fas fa-clock',
								];

							@endphp

							@foreach ($menuItemsWithSubmenus as $menuItem)
							@php
								$isSubMenuActive = false;

								foreach ($menuItem['subMenus'] as $subMenu) {
									if (request()->is($subMenu->menu_link) || request()->routeIs($subMenu->menu_link)) {
										$isSubMenuActive = true;
										break;
									}
								}
							@endphp

							<li class="{{ $isSubMenuActive ? 'active-sub' : '' }}">
								<a href="#">
									@if (isset($iconsByMenuName[$menuItem['mainMenu']->menu_name]))
										<i class="{{ $iconsByMenuName[$menuItem['mainMenu']->menu_name] }}"></i>
									@else
										<i class="fas fa-home"></i> <!-- Ini adalah contoh ikon default -->
									@endif
									<span class="menu-title">{{ $menuItem['mainMenu']->menu_name }}</span>
									<i class="arrow"></i>
								</a>
								@if ($menuItem['subMenus']->count() > 0)
									<ul class="collapse {{ $isSubMenuActive ? 'in' : '' }}">
										@foreach ($menuItem['subMenus'] as $subMenu)
											<li class="{{ request()->is($subMenu->menu_link) || request()->routeIs($subMenu->menu_link) ? 'active-link' : '' }}">
												<a href="{{ route($subMenu->menu_link) }}">
													{{ $subMenu->menu_name }}
												</a>
											</li>
										@endforeach
									</ul>
								@endif
							</li>
							@endforeach --}}
						</ul>
				</div>
			</div>
		</div>
		<!--================================-->
		<!--End menu-->
		
	</div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
	document.addEventListener("DOMContentLoaded", function() {
	  const masterMenuCollapse = document.getElementById("masterMenuCollapse");
	  const masterMenuLink = document.querySelector(".nav-item[data-toggle='collapse'] .nav-link");
  
	  // Cek apakah dropdown Master Menu harus ditampilkan saat halaman dimuat
	  if (masterMenuLink.classList.contains("active")) {
		masterMenuCollapse.classList.add("show");
	  }
  
	  masterMenuLink.addEventListener("click", function(event) {
		event.preventDefault();
  
		// Toggle collapse secara manual
		masterMenuCollapse.classList.toggle("show");
	  });
  
	  // Tambahkan event listener untuk menutup dropdown saat klik di area lain
	  document.addEventListener("click", function(event) {
		const target = event.target;
  
		// Cek apakah target adalah area di luar dropdown dan tidak ada elemen masterMenuLink yang diklik
		if (!target.closest("#masterMenuCollapse") && !target.classList.contains("nav-link")) {
		  masterMenuCollapse.classList.remove("show");
		}
	  });
	});
  </script>
