 <!-- navbar  -->
 <nav class="navbar navbar-expand-lg fixed-top navbar-light navbar-dark" style="background-color: #3A7E18">
    {{-- <a class="navbar-nav" href="#">Pilly</a> --}}
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
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