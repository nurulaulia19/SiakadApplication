 <!-- navbar  -->
 <nav class="navbar navbar-expand-lg fixed-top navbar-light navbar-dark" style="background-color: #3A7E18">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <a class="navbar-nav" href="#">Pilly</a> --}}
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item {{ request()->routeIs('landingpage') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('landingpage') }}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item {{ request()->routeIs('landingpage.berita') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('landingpage.berita') }}">Berita</a>
        </li>
        <li class="nav-item {{ request()->routeIs('landingpage.brosur') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('landingpage.brosur') }}">Brosur</a>
        </li>
        <li class="nav-item {{ request()->routeIs('landingpage.galeri') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('landingpage.galeri') }}">Galeri</a>
        </li>

        {{-- bener --}}
        {{-- <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="sekolahDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
              Ekstrakulikuler
          </button>
          <ul class="dropdown-menu" aria-labelledby="sekolahDropdownButton">
              @foreach ($sekolahOptions as $id => $nama)
                  <li>
                      <div class="dropdown dropend">
                          <button class="dropdown-item sekolah-item" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-sekolah="{{ $id }}">
                              {{ $nama }}
                          </button>
                          <ul class="dropdown-menu judul-dropdown" id="judulDropdown_{{ $id }}">
                              <!-- Judul Ekstrakulikuler akan ditambahkan melalui JavaScript -->
                          </ul>
                      </div>
                  </li>
              @endforeach
          </ul>
        </div>       --}}
        {{-- bener --}}
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
          $(document).ready(function () {
              // Menangani hover pada item sekolah
              $('.sekolah-item').on('mouseenter', function () {
                  var selectedSekolahId = $(this).data('sekolah');
                  var judulDropdown = $('#judulDropdown_' + selectedSekolahId);
      
                  // Kirim permintaan Ajax untuk mendapatkan judul ekstrakulikuler berdasarkan sekolah yang dipilih
                  $.ajax({
                      url: '/get-ekstrakulikuler/' + selectedSekolahId,
                      type: 'GET',
                      success: function (data) {
                          console.log(data); // Log the data received from the server
                          // Hapus opsi yang ada di dropdown judul
                          judulDropdown.empty();
      
                          // Tambahkan opsi untuk setiap judul ekstrakulikuler
                          $.each(data, function (index, judul) {
                              judulDropdown.append('<li><a class="dropdown-item" href="#">' + judul + '</a></li>');
                          });
      
                          // Tampilkan dropdown ekstrakulikuler
                          judulDropdown.show();
                      }
                  });
              });
      
              // Menangani hover pada item dropdown judul ekstrakulikuler
              $('.dropdown').on('mouseleave', function () {
                  // Sembunyikan dropdown ekstrakulikuler ketika mouse meninggalkan area dropdown
                  $('.judul-dropdown').hide();
              });
          });
        </script> --}}
        <div class="dropdown">
          <button class="btn dropdown-toggle text-white" style="border: none;" type="button" id="sekolahDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
            Ekstrakulikuler
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sekolahDropdownButton">
            @foreach ($sekolahOptions as $id => $nama)
              <div class="d-flex">
                <button class="dropdown-item sekolah-item" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-sekolah="{{ $id }}">
                  {{ $nama }}
                </button>
                <ul class="dropdown-menu-end dropdown judul-dropdown" id="judulDropdown_{{ $id }}">
                  <!-- Judul Ekstrakulikuler akan ditambahkan melalui JavaScript -->
                </ul>
              </div>
            @endforeach
          </ul>
        </div>
      
        <style>
          /* Menghilangkan tanda list kotak pada dropdown menu */
          .dropdown-menu-end.judul-dropdown {
            list-style: none;
            padding: 0;
            margin: 0;
          }

          /* Menambahkan gaya pada setiap item dalam dropdown menu */
          .dropdown-menu-end.judul-dropdown button {
            display: block;
            width: 100%;
            padding: 0.25rem 1.5rem;
            clear: both;
            font-weight: normal;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
          }

          .dropdown-toggle {
              border-radius: 0 !important;
          }

          .dropdown-menu {
              border-radius: 0 !important;
          }

          .dropdown-item {
              border-radius: 0 !important;
          }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script>
          $(document).ready(function () {
          // Variabel untuk menyimpan judul terakhir
          var lastDisplayedJudulId;

          // Menangani hover pada item sekolah
          $('.sekolah-item').on('mouseenter', function () {
            var selectedSekolahId = $(this).data('sekolah');
            var judulDropdown = $('#judulDropdown_' + selectedSekolahId);

            // Periksa apakah dropdown judul berbeda sebelum menampilkan judul baru
            if (selectedSekolahId !== lastDisplayedJudulId) {
              // Sembunyikan dropdown judul terakhir
              $('#judulDropdown_' + lastDisplayedJudulId).hide();

              // Kirim permintaan Ajax untuk mendapatkan judul ekstrakulikuler berdasarkan sekolah yang dipilih
              $.ajax({
                url: '/get-ekstrakulikuler/' + selectedSekolahId,
                type: 'GET',
                success: function (data) {
                  console.log(data); // Log data yang diterima dari server
                  // Hapus opsi yang ada di dropdown judul
                  judulDropdown.empty();

                  // Tambahkan opsi untuk setiap judul ekstrakulikuler
                  $.each(data, function (index, judul) {
                    judulDropdown.append('<li><a class="dropdown-item" href="#">' + judul + '</a></li>');
                  });

                  // Tampilkan dropdown ekstrakulikuler
                  judulDropdown.show();

                  // Perbarui variabel judul terakhir
                  lastDisplayedJudulId = selectedSekolahId;
                }
              });
            }
          });

          // Menangani hover pada item dropdown judul ekstrakulikuler
          $('.dropdown').on('mouseleave', function () {
            // Sembunyikan dropdown ekstrakulikuler ketika mouse meninggalkan area dropdown
            $('.judul-dropdown').hide();
          });
        });

        </script>
        {{-- <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li> --}}
      </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              {{-- <a class="nav-link" href="#">
                 <i class="fa fa-github" aria-hidden="true"></i>
                  <span class="sr-only">(current)</span>
              </a> --}}
              <div>
                @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            {{-- <a href="{{ url('admin/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a> --}}
                            <a href="{{ Auth::user()->role_id === 2 ? url('admin/homeGuru') : url('admin/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                        @else
                            <a href="{{ route('Adminlogin') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 text-white" style="text-decoration: none">Log in</a>

                            @if (Route::has('register'))
                                {{-- <a href="{{ route('Adminregister') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a> --}}
                            @endif
                            <a href="{{ route('siswa.login') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 text-white" style="text-decoration: none">Login Siswa</a>
                        @endauth
                    </div>
                @endif
              </div>
            </li>
        </ul>
    </div>
  </nav>