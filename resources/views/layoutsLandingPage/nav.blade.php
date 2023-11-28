 <!-- navbar  -->
 <nav class="navbar navbar-expand-lg fixed-top navbar-light navbar-dark" style="background-color: #3A7E18">
    {{-- <a class="navbar-nav" href="#">Pilly</a> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-dmc3Y9D9hqUHva4a6f5eAj4PJJM4QI0l0tSrWv9pWVUtdKFRnYbV5C5D1MOjbp2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <style>
      .dropdown-submenu {
        position: relative;
      }
  
      .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
        border-radius: 0%;
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

          .judul:hover {
            background-color: #E6E6E6 !important; /* use !important to ensure the styles are applied on hover */
          }
          
    </style>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item {{ request()->routeIs('landingpage') ? 'active' : '' }}" >
            <a class="nav-link" href="{{ route('landingpage') }}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item {{ request()->routeIs('landingpage.berita') || request()->routeIs('berita.detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('landingpage.berita') }}">Berita</a>
        </li>
        <li class="nav-item {{ request()->routeIs('landingpage.brosur') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('landingpage.brosur') }}">Brosur</a>
        </li>
        <li class="nav-item {{ request()->routeIs('landingpage.galeri') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('landingpage.galeri') }}">Galeri</a>
        </li>
        {{-- <div class="dropdown">
          <button class="btn dropdown-toggle text-white" style="border: none;" type="button" id="sekolahDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
            Ekstrakulikuler
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sekolahDropdownButton">
            @foreach ($sekolahOptions as $id => $nama)
              <div class="d-flex">
                <button class="dropdown-item sekolah-item" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-sekolah="{{ $id }}">
                  {{ $nama }}
                </button>
                @php
                $eskul = App\Http\Controllers\LandingPageController::getEkstrakulikulerBySekolah($id);
                
                @endphp

                <a href="#">
                  <ul class="dropdown-menu-end dropdown judul-dropdown">
                    @foreach ($eskul as $item)
                        <li><a href="{{ route ('ekstrakulikuler.detail', $item->id_ekstrakulikuler) }}"> {{ $item->judul }}</a></li>
                    @endforeach
                      <!-- Judul Ekstrakulikuler akan ditambahkan melalui JavaScript -->
                  </ul>
                </a>              
              </div>
            @endforeach
          </ul>
        </div> --}}
        {{-- <div class="dropdown">
          <button class="btn dropdown-toggle text-white" style="border: none;" type="button" data-toggle="dropdown" >
            Ekstrakulikuler
          <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#">HTML</a></li>
            <li><a href="#">CSS</a></li>
            <li class="dropdown-submenu">
              <a class="test" href="#">New dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">2nd level dropdown</a></li>
                <li><a href="#">2nd level dropdown</a></li>
                <li class="dropdown-submenu">
                  <a class="test" href="#">Another dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">3rd level dropdown</a></li>
                    <li><a href="#">3rd level dropdown</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </div> --}}
        {{-- <div class="dropdown">
          <button class="btn dropdown-toggle text-white btn-sm" style="border: none;" type="button" data-toggle="dropdown">
            Ekstrakulikuler
            <i class="bi bi-caret-down"></i>
          </button>          
          <ul class="dropdown-menu">
            @foreach ($sekolahOptions as $id => $nama)
            <li class="dropdown-submenu" style="border-radius: 0;">
              <a class="test text-center" style="margin-left: 20px; padding-top: 5px; padding-bottom: 5px; border-radius: 0; text-decoration: none;" href="#">{{ $nama }} <i class="bi bi-caret-down"></i></a>
                <ul class="dropdown-menu">
                  @php
                    $eskul = App\Http\Controllers\LandingPageController::getEkstrakulikulerBySekolah($id);
                  @endphp
                  @foreach ($eskul as $item)
                    <li><a style="margin-left: 20px;" class="text-center" href="{{ route ('ekstrakulikuler.detail', $item->id_ekstrakulikuler) }}">{{ $item->judul }}</a></li>
                  @endforeach
                  <!-- Judul Ekstrakulikuler akan ditambahkan melalui JavaScript -->
                </ul>
                                
              </li>
            @endforeach
          </ul>
          
        </div> --}}
        {{-- <div class="navbar-nav ml-auto" style="list-style: none; padding: 0;">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
              Ekstrakulikuler
              <i class="bi bi-caret-down"></i>
            </a>
            <ul class="dropdown-menu" style="padding: 0;">
              @foreach ($sekolahOptions as $id => $nama)
                <li class="dropdown-submenu">
                  <a class="test text-center" style="margin-left: 20px; padding-top: 5px; padding-bottom: 5px; border-radius: 0; text-decoration: none; color: black; line-height: 1;" href="#">
                    {{ $nama }}
                    <i class="bi bi-caret-down"></i>
                  </a>
                  <ul class="dropdown-menu" style="padding: 0;">
                    @php
                      $eskul = App\Http\Controllers\LandingPageController::getEkstrakulikulerBySekolah($id);
                    @endphp
                    @foreach ($eskul as $item)
                      <li>
                        <a style="margin-left: 20px; color: black; line-height: 1;" class="text-center" href="{{ route ('ekstrakulikuler.detail', $item->id_ekstrakulikuler) }}">
                          {{ $item->judul }}
                        </a>
                      </li>
                    @endforeach
                    <!-- Judul Ekstrakulikuler akan ditambahkan melalui JavaScript -->
                  </ul>
                </li>
              @endforeach
            </ul>
          </li>
        
          <!-- ... other nav items ... -->
        </div> --}}
        {{-- <div class="nav-item dropdown">
          <button class="btn btn-default dropdown-toggle @if(Request::is('ekstrakulikuler/detail/*')) active @endif" type="button" data-toggle="dropdown">Ekstrakulikuler
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            @foreach ($sekolahOptions as $id => $nama)
            <li class="dropdown-submenu">
              <a class="test text-center" style="margin-left: 20px; padding-top: 5px; padding-bottom: 5px; border-radius: 0; text-decoration: none; color: black; line-height: 1;" href="#">
                {{ $nama }}
                <i class="bi bi-caret-down"></i>
              </a>
              <ul class="dropdown-menu" style="padding: 0;">
                @php
                  $eskul = App\Http\Controllers\LandingPageController::getEkstrakulikulerBySekolah($id);
                @endphp
                @foreach ($eskul as $item)
                  <li>
                    <a style="margin-left: 20px; color: black; line-height: 1;" class="text-center" href="{{ route ('ekstrakulikuler.detail', $item->id_ekstrakulikuler) }}">
                      {{ $item->judul }}
                    </a>
                  </li>
                @endforeach
                <!-- Judul Ekstrakulikuler akan ditambahkan melalui JavaScript -->
              </ul>
            </li>
          @endforeach
          </ul>
        </div> --}}
        <li class="nav-item dropdown {{ request()->routeIs('ekstrakulikuler*') ? 'active' : '' }}">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
              Ekstrakulikuler
              <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
              @foreach ($sekolahOptions as $id => $nama)
                  <li class="dropdown-submenu dropdown-item">
                      <a class="test text-center @if(Request::is("ekstrakulikuler/detail/$id")) active @endif" style="padding-top: 5px; padding-bottom: 5px; border-radius: 0; text-decoration: none; color: black; line-height: 1;" href="#">
                          {{ $nama }}
                          <i style="font-size:12px; padding:left:2px" class="fas fa-caret-down"></i>
                      </a>
                      <ul class="dropdown-menu">
                          @php
                              $eskul = App\Http\Controllers\LandingPageController::getEkstrakulikulerBySekolah($id);
                          @endphp
                          @foreach ($eskul as $item)
                              <li class="judul dropdown-item">
                                  <a style="color: black; line-height: 1; text-decoration:none;" class="text-center @if(Request::is("ekstrakulikuler/detail/$item->id_ekstrakulikuler")) active @endif" href="{{ route ('ekstrakulikuler.detail', $item->id_ekstrakulikuler) }}">
                                      {{ $item->judul }}
                                  </a>
                              </li>
                          @endforeach
                      </ul>
                  </li>
              @endforeach
          </ul>
        </li>

        {{-- <script>
          $(document).ready(function(){
            $('.dropdown-submenu a.test').on("click", function(e){
              $(this).next('ul').toggle();
              e.stopPropagation();
              e.preventDefault();
            });
          });
          </script> --}}
          <script>
            $(document).ready(function () {
                $('.dropdown-submenu').hover(
                    function () {
                        $(this).find('ul').show();
                        $(this).css('background-color', '#E6E6E6'); // Change the background color on hover
                        
                    },
                    function () {
                        $(this).find('ul').hide();
                        $(this).css('background-color', ''); // Reset to default background color when not hovered
                    }
                );
        
                
                // To handle the anchor click
                $('.dropdown-submenu a.test').on("click", function (e) {
                    $(this).next('ul').toggle();
                    e.stopPropagation();
                    e.preventDefault();
                });

            });
          </script>
        
        
        {{-- ================================== --}}
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