<?php

use App\Http\Controllers\AbsensiGuruController;
use App\Models\RoleMenu;
use FontLib\Table\Type\name;
use App\Models\GuruPelajaran;
use App\Mail\VerificationCode;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DataTokoController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DataNilaiController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataProdukController;
use App\Http\Controllers\NilaiSiswaController;
use App\Http\Controllers\AksesCabangController;
use App\Http\Controllers\JadwalSiswaController;
use App\Http\Controllers\AbsensiSiswaController;
use App\Http\Controllers\AksesSekolahController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DataBeritaController;
use App\Http\Controllers\DataBrosurController;
use App\Http\Controllers\DataKuisionerController;
use App\Http\Controllers\DataPelajaranController;
use App\Http\Controllers\DataSliderController;
use App\Http\Controllers\GuruPelajaranController;
use App\Http\Controllers\KategoriNilaiController;
use App\Http\Controllers\KenaikanKelasController;
use App\Http\Controllers\PelajaranKelasController;
use App\Http\Controllers\TransaksiDetailAditional;
use App\Http\Controllers\TransaksiDetailController;
use App\Http\Controllers\KategoriKuisionerController;
use App\Http\Controllers\GuruPelajaranJadwalController;
use App\Http\Controllers\JadwalGuruController;
use App\Http\Controllers\KuisionerGuruController;
use App\Http\Controllers\KuisionerSiswaController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\NilaiGuruController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// });
Route::get('/admin/dashboard2', function () {
    return view('admin/dashboard2');
});
Route::get('/admin/dashboard3', function () {
    return view('admin/dashboard3');
});

Route::get('/admin/user', function () {
    return view('admin/user');
});

Route::get('/admin/transaksi/modal', function () {
    return view('transaksi/modal');
});

// Route::get('menu.update', function () {
//     return view('menu/update');
// });




Auth::routes();

Auth::routes([
    'verify' =>true
]);
// Route::post('/login', [LoginController::class, 'login'])->name('login')->middleware('checkUserRole');
Route::get('logout', [LoginController::class, 'logout']);
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('Adminlogin');
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('Adminregister');
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');
// Route::get('logout', [LoginController::class, 'showRegisterForm']);
Route::get('/admin/user', [App\Http\Controllers\KategoriKuisionerController::class, 'user'])->name('user');
Route::get('/admin/role', [App\Http\Controllers\MenuController::class, 'role'])->name('role');
Route::get('/admin/user', function () {
    return view('user');
});

Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu/store', [MenuController::class, 'store']);
Route::get('/admin/menu', [MenuController::class,'index'])->name('menu.index');
Route::get('/admin/menu/destroy/{id}', [MenuController::class,'destroy'])->name('menu.destroy');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');

// role
Route::put('/admin/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::get('/admin/role/create', [RoleController::class, 'create'])->name('role.create');
Route::get('/admin/role', [RoleController::class,'index'])->name('role.index');
Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/role/store', [RoleController::class, 'store']);
Route::get('/admin/role/destroy/{id}', [RoleController::class,'destroy'])->name('role.destroy');

// user
Route::put('/admin/user/update/{id}', [DataUserController::class, 'update'])->name('user.update');
Route::get('/admin/user/create', [DataUserController::class, 'create'])->name('user.create');
Route::get('/admin/user', [DataUserController::class,'index'])->name('user.index');
Route::get('/admin/user/edit/{id}', [DataUserController::class, 'edit'])->name('user.edit');
Route::post('/user/store', [DataUserController::class, 'store']);
Route::get('/admin/user/destroy/{id}', [DataUserController::class,'destroy'])->name('user.destroy');

// edit profil
Route::middleware(['auth'])->group(function () {
    Route::get('/profil/edit', [DataUserController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil/update', [DataUserController::class, 'updateProfil'])->name('profil.update');
});


// edit password
Route::middleware(['auth'])->group(function () {
    Route::get('/password/edit', [DataUserController::class, 'editPassword'])->name('password.edit');
    Route::put('/password/update', [DataUserController::class, 'updatePassword'])->name('password.update');
});


// sidebar
Route::get('/sidebar2', [MenuController::class,'getSidebar'])->name('sidebar'); // Ganti dengan controller dan rute yang relevan

// data sekolah
Route::put('/admin/sekolah/update/{id}', [SekolahController::class, 'update'])->name('sekolah.update');
Route::get('/admin/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
Route::get('/admin/sekolah', [SekolahController::class,'index'])->name('sekolah.index');
Route::get('/admin/sekolah/edit/{id}', [SekolahController::class, 'edit'])->name('sekolah.edit');
Route::post('/sekolah/store', [SekolahController::class, 'store']);
Route::get('/admin/sekolah/destroy/{id}', [SekolahController::class,'destroy'])->name('sekolah.destroy');

// data kelas
Route::put('/admin/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
Route::get('/admin/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
Route::get('/admin/kelas', [KelasController::class,'index'])->name('kelas.index');
Route::get('/admin/kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
Route::post('/kelas/store', [KelasController::class, 'store']);
Route::get('/admin/kelas/destroy/{id}', [KelasController::class,'destroy'])->name('kelas.destroy');

// data mata pelajaran
Route::put('/admin/mapel/update/{id}', [DataPelajaranController::class, 'update'])->name('mapel.update');
Route::get('/admin/mapel/create', [DataPelajaranController::class, 'create'])->name('mapel.create');
Route::get('/admin/mapel', [DataPelajaranController::class,'index'])->name('mapel.index');
Route::get('/admin/mapel/edit/{id}', [DataPelajaranController::class, 'edit'])->name('mapel.edit');
Route::post('/mapel/store', [DataPelajaranController::class, 'store']);
Route::get('/admin/mapel/destroy/{id}', [DataPelajaranController::class,'destroy'])->name('mapel.destroy');


// data mata pelajaran perkelas
Route::put('/admin/mapelKelas/update/{id}', [PelajaranKelasController::class, 'update'])->name('mapelKelas.update');
Route::get('/admin/mapelKelas/create', [PelajaranKelasController::class, 'create'])->name('mapelKelas.create');
Route::get('/admin/mapelKelas', [PelajaranKelasController::class,'index'])->name('mapelKelas.index');
Route::get('/admin/mapelKelas/edit/{id}', [PelajaranKelasController::class, 'edit'])->name('mapelKelas.edit');
Route::post('/mapelKelas/store', [PelajaranKelasController::class, 'store']);
Route::get('/admin/mapelKelas/destroy/{id}', [PelajaranKelasController::class,'destroy'])->name('mapelKelas.destroy');

Route::get('/admin/mapelKelas/getKelas', [PelajaranKelasController::class, 'getKelas'])->name('mapelKelas.getKelas');
Route::get('/admin/mapelKelas/getMapel', [PelajaranKelasController::class, 'getMapel'])->name('mapelKelas.getMapel');

// filter berdasarkan sekolah
// Route::get('/get-data-by-sekolah', [PelajaranKelasController::class,'create']);
// Route::get('/get-options-by-sekolah', [PelajaranKelasController::class,'getOptionsBySekolah']);


// data siswa
Route::put('/admin/siswa/update/{id}', [DataSiswaController::class, 'update'])->name('siswa.update');
Route::get('/admin/siswa/create', [DataSiswaController::class, 'create'])->name('siswa.create');
Route::get('/admin/siswa', [DataSiswaController::class,'index'])->name('siswa.index');
Route::get('/admin/siswa/edit/{id}', [DataSiswaController::class, 'edit'])->name('siswa.edit');
Route::post('/siswa/store', [DataSiswaController::class, 'store']);
Route::get('/admin/siswa/destroy/{id}', [DataSiswaController::class,'destroy'])->name('siswa.destroy');

Route::get('/export-pdf/{tahun?}', [DataSiswaController::class, 'exportPDF'])->name('exportSiswa.pdf');
Route::get('/export-excel/{tahun?}', [DataSiswaController::class, 'exportExcel'])->name('exportSiswa.excel');


// data kenaikan kelas
Route::put('/admin/kenaikanKelas/update/{id}', [KenaikanKelasController::class, 'update'])->name('kenaikanKelas.update');
Route::get('/admin/kenaikanKelas/create', [KenaikanKelasController::class, 'create'])->name('kenaikanKelas.create');
Route::get('/admin/kenaikanKelas', [KenaikanKelasController::class,'index'])->name('kenaikanKelas.index');
Route::get('/admin/kenaikanKelas/edit/{id}', [KenaikanKelasController::class, 'edit'])->name('kenaikanKelas.edit');
Route::post('/kenaikanKelas/store', [KenaikanKelasController::class, 'store']);
Route::get('/admin/kenaikanKelas/destroy/{id}', [KenaikanKelasController::class,'destroy'])->name('kenaikanKelas.destroy');
// Route::get('/admin/kenaikanKelas/cariKelas', [KenaikanKelasController::class, 'cariKelas'])->name('kenaikanKelas.cariKelas');
// Route::get('/getStudentsBySchool/{id_sekolah}', [KenaikanKelasController::class, 'getStudentsBySchool']);


// Route::get('/get-siswa-by-sekolah/{id_sekolah}', [KenaikanKelasController::class,'getSiswaBySekolah']);

Route::get('/admin/kenaikanKelas/getkelas', [KenaikanKelasController::class, 'getKelas'])->name('kenaikanKelas.getkelas');
Route::get('/admin/kenaikanKelas/getsiswa', [KenaikanKelasController::class, 'getSiswa'])->name('kenaikanKelas.getsiswa');


// data guru 
Route::put('/admin/guruMapel/update/{id}', [GuruPelajaranController::class, 'update'])->name('guruMapel.update');
Route::get('/admin/guruMapel/create', [GuruPelajaranController::class, 'create'])->name('guruMapel.create');
Route::get('/admin/guruMapel', [GuruPelajaranController::class,'index'])->name('guruMapel.index');
Route::get('/admin/guruMapel/edit/{id}', [GuruPelajaranController::class, 'edit'])->name('guruMapel.edit');
Route::post('/guruMapel/store', [GuruPelajaranController::class, 'store']);
Route::get('/admin/guruMapel/destroy/{id}', [GuruPelajaranController::class,'destroy'])->name('guruMapel.destroy');
Route::get('/admin/guruMapel/getKelas', [GuruPelajaranController::class, 'getKelas'])->name('guruMapel.getKelas');
Route::get('/admin/guruMapel/getMapel', [GuruPelajaranController::class, 'getMapel'])->name('guruMapel.getMapel');

// data nilai
Route::get('/admin/dataNilai/nilai', [GuruPelajaranController::class,'nilai'])->name('dataNilai.nilai');
Route::get('/admin/dataNilai/detail/{id_gp}', [GuruPelajaranController::class, 'detailNilai'])->name('dataNilai.detail');
Route::post('/admin/dataNilai/store', [GuruPelajaranController::class, 'storeNilai'])->name('dataNilai.store');
Route::get('/admin/dataNilai/produk', [DataProdukController::class,'laporanProduk'])->name('laporan.laporanProduk');
Route::get('/export/pdf/{id_gp}/{id_kn}', [GuruPelajaranController::class, 'exportToPDF'])->name('export.pdf');
Route::get('/export/excel/{id_gp}/{id_kn}', [GuruPelajaranController::class, 'exportToExcel'])->name('export.excel');

// data absensi
Route::get('/admin/dataAbsensi/absensi', [GuruPelajaranController::class,'absensi'])->name('dataAbsensi.absensi');
Route::get('/admin/dataAbsensi/detail/{id_gp}', [GuruPelajaranController::class, 'detailAbsensi'])->name('dataAbsensi.detail');
Route::post('/admin/dataAbsensi/store', [GuruPelajaranController::class, 'storeAbsensi'])->name('dataAbsensi.store');
Route::post('/admin/dataAbsensiDetail/store', [GuruPelajaranController::class, 'storeAbsensiDetail'])->name('dataAbsensiDetail.store');
Route::delete('/admin/dataAbsensi/destroy/{id_absensi}', [GuruPelajaranController::class, 'destroyAbsensi'])->name('dataAbsensi.destroy');

// laporan absensi
Route::get('/admin/dataAbsensi/laporanAbsensi', [GuruPelajaranController::class,'laporanAbsensi'])->name('dataAbsensi.laporanAbsensi');
Route::post('/admin/dataAbsensi/tampilkanAbsensi', [GuruPelajaranController::class,'tampilkanAbsensi'])->name('dataAbsensi.tampilkanAbsensi');
// Route::match(['get', 'post'], '/admin/dataAbsensi/tampilkanAbsensi', [GuruPelajaranController::class, 'tampilkanAbsensi'])->name('dataAbsensi.tampilkanAbsensi');
Route::get('/admin/dataAbsensi/get-mapel-by-kelas', [GuruPelajaranController::class, 'getMapelByKelas'])->name('dataAbsensi.getMapelByKelas');
Route::get('/export/absensi/pdf/{id_sekolah}/{id_kelas}/{tahun_ajaran}/{id_pelajaran}', [GuruPelajaranController::class, 'exportAbsensiToPDF'])->name('exportAbsensi.pdf');
Route::get('/export/absensi/excel/{id_sekolah}/{id_kelas}/{tahun_ajaran}/{id_pelajaran}', [GuruPelajaranController::class, 'exportAbsensiToExcel'])->name('exportAbsensi.excel');


// guru pelajaran jadwal
Route::post('/admin/guruMapelJadwal/store', [GuruPelajaranJadwalController::class, 'store'])->name('guruMapelJadwal.store');
Route::get('/admin/guruMapelJadwal/destroy/{id_gpj}', [GuruPelajaranJadwalController::class, 'destroy'])->name('guruMapelJadwal.destroy');


// ketegori nilai
Route::put('/admin/kategoriNilai/update/{id}', [KategoriNilaiController::class, 'update'])->name('kategoriNilai.update');
Route::get('/admin/kategoriNilai/create', [KategoriNilaiController::class, 'create'])->name('kategoriNilai.create');
Route::get('/admin/kategoriNilai', [KategoriNilaiController::class,'index'])->name('kategoriNilai.index');
Route::get('/admin/kategoriNilai/edit/{id}', [KategoriNilaiController::class, 'edit'])->name('kategoriNilai.edit');
Route::post('/kategoriNilai/store', [KategoriNilaiController::class, 'store']);
Route::get('/admin/kategoriNilai/destroy/{id}', [KategoriNilaiController::class,'destroy'])->name('kategoriNilai.destroy');

// cek nilai
Route::get('/admin/dataNilai/cekNilai', [GuruPelajaranController::class,'cekNilai'])->name('dataNilai.cekNilai');
Route::post('/admin/dataNilai/tampilkanNilai', [GuruPelajaranController::class,'tampilkanNilai'])->name('dataNilai.tampilkanNilai');
Route::get('/export/nilai/pdf/{id_sekolah}/{nis_siswa}', [GuruPelajaranController::class, 'exportNilaiToPDF'])->name('exportNilai.pdf');
Route::get('/export/nilai/excel/{id_sekolah}/{nis_siswa}', [GuruPelajaranController::class, 'exportNilaiToExcel'])->name('exportNilai.excel');

// akses sekolah
Route::get('/admin/aksessekolah', [AksesSekolahController::class,'index'])->name('aksessekolah.index');
Route::put('/admin/aksessekolah/update/{id}', [AksesSekolahController::class, 'update'])->name('aksessekolah.update');
Route::get('/admin/aksessekolah/create', [AksesSekolahController::class, 'create'])->name('aksessekolah.create');
Route::get('/admin/aksessekolah/edit/{id}', [AksesSekolahController::class, 'edit'])->name('aksessekolah.edit');
Route::post('/aksessekolah/store', [AksesSekolahController::class, 'store']);
Route::get('/admin/aksessekolah/destroy/{id}', [AksesSekolahController::class,'destroy'])->name('aksessekolah.destroy');

// login siswa
// Route::get('siswa/login', [Auth\SiswaLoginController::class,'showLoginForm'])->name('siswa.login');
// Route::post('siswa/login', [Auth\SiswaLoginController::class,'login'])->name('siswa.login.submit');

// Route::group(['prefix' => 'siswa', 'as' => 'siswa.', 'namespace' => 'Siswa'], function () {
//     Route::get('/login', [SiswaAuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [SiswaAuthController::class, 'login'])->name('login.submit');
// });

// data kategori kuisioner admin
Route::get('/admin/kategoriKuisioner/create', [KategoriKuisionerController::class, 'create'])->name('kategoriKuisioner.create');
Route::post('/kategoriKuisioner/store', [KategoriKuisionerController::class, 'store']);
Route::get('/admin/kategoriKuisioner', [KategoriKuisionerController::class,'index'])->name('kategoriKuisioner.index');
Route::get('/admin/kategoriKuisioner/destroy/{id}', [KategoriKuisionerController::class,'destroy'])->name('kategoriKuisioner.destroy');
Route::get('/admin/kategoriKuisioner/edit/{id}', [KategoriKuisionerController::class, 'edit'])->name('kategoriKuisioner.edit');
Route::put('/admin/kategoriKuisioner/update/{id}', [KategoriKuisionerController::class, 'update'])->name('kategoriKuisioner.update');

// data kuisioner admin
Route::get('/admin/kuisioner/create', [DataKuisionerController::class, 'create'])->name('kuisioner.create');
Route::post('/kuisioner/store', [DataKuisionerController::class, 'store']);
Route::get('/admin/kuisioner', [DataKuisionerController::class,'index'])->name('kuisioner.index');
Route::get('/admin/kuisioner/destroy/{id}', [DataKuisionerController::class,'destroy'])->name('kuisioner.destroy');
Route::get('/admin/kuisioner/edit/{id}', [DataKuisionerController::class, 'edit'])->name('kuisioner.edit');
Route::put('/admin/kuisioner/update/{id}', [DataKuisionerController::class, 'update'])->name('kuisioner.update');
Route::get('/admin/kuisioner/getKategori', [DataKuisionerController::class, 'getKategori'])->name('kuisioner.getKategori');

// laporan kuisioner admin
Route::get('/admin/kuisioner/kuisioner', [GuruPelajaranController::class,'laporanKuisioner'])->name('laporanKuisioner.index');
Route::get('/admin/kuisioner/detail/{id_gp}', [GuruPelajaranController::class, 'detailLaporanKuisioner'])->name('laporanKuisioner.detail');

// login siswa
Route::get('/siswa/login', [SiswaAuthController::class, 'showLoginForm'])->name('siswa.login');
Route::post('/siswa/submit', [SiswaAuthController::class, 'login'])->name('siswa.submit');

// tampilan siswa
Route::get('/siswa/home', [App\Http\Controllers\HomeSiswaController::class, 'index'])->name('siswa.home');

// edit profil siswa
Route::middleware(['auth:siswa'])->group(function () {
    Route::get('/profilSiswa/edit', [DataSiswaController::class, 'editProfilSiswa'])->name('profilSiswa.edit');
    Route::put('/profilSiswa/update', [DataSiswaController::class, 'updateProfilSiswa'])->name('profilSiswa.update');
});

// edit password siswa
Route::middleware(['auth:siswa'])->group(function () {
    Route::get('/passwordSiswa/edit', [DataSiswaController::class, 'editSiswaPassword'])->name('passwordSiswa.edit');
    Route::put('/passwordSiswa/update', [DataSiswaController::class, 'updateSiswaPassword'])->name('passwordSiswa.update');
});

// sidebar siswa
// jadwal
Route::get('/siswa/jadwal', [JadwalSiswaController::class,'index'])->name('jadwal.index');
Route::get('/exportjadwal-pdf', [JadwalSiswaController::class, 'exportPDF'])->name('exportJadwalSiswa.pdf');
Route::get('/exportjadwal-excel', [JadwalSiswaController::class, 'exportExcel'])->name('exportJadwalSiswa.excel');

// nilai
Route::get('/siswa/nilai', [NilaiSiswaController::class,'index'])->name('nilai.index');
Route::get('/exportnilai-pdf', [NilaiSiswaController::class, 'exportPDF'])->name('exportNilaiSiswa.pdf');
Route::get('/exportnilai-excel', [NilaiSiswaController::class, 'exportExcel'])->name('exportNilaiSiswa.excel');

// absensi
Route::get('/siswa/absensi', [AbsensiSiswaController::class,'index'])->name('absensi.index');
Route::get('/siswa/detail/absensi/{id_gp}', [AbsensiSiswaController::class,'detailAbsensi'])->name('absensiSiswa.detail');

// kuisioner u/ siswa
Route::get('/siswa/kuisioner', [KuisionerSiswaController::class,'index'])->name('kuisionerSiswa.index');
Route::get('/siswa/detail/kuisioner/{id_gp}', [KuisionerSiswaController::class,'detailKuisioner'])->name('kuisionerSiswa.detail');
Route::post('/siswa/jawaban/kuisioner', [KuisionerSiswaController::class,'storeJawabanKuisioner'])->name('jawabanKuisioner.store');
Route::get('/siswa/isi/kuisioner/{id_gp}', [KuisionerSiswaController::class,'isiKuisioner'])->name('kuisionerSiswa.isi');

// menu guru
// jadwal
Route::get('/admin/jadwalGuru', [JadwalGuruController::class,'index'])->name('jadwalGuru.index');
Route::get('/exportjadwalguru-pdf', [JadwalGuruController::class, 'exportJadwalPDF'])->name('exportJadwalGuru.pdf');
Route::get('/exportjadwalguru-excel', [JadwalGuruController::class, 'exportJadwalExcel'])->name('exportJadwalGuru.excel');

// nilai
Route::get('/admin/nilaiGuru', [NilaiGuruController::class,'index'])->name('nilaiGuru.index');
Route::get('/admin/nilaiGuru/detail/{id_gp}', [NilaiGuruController::class, 'detail'])->name('nilaiGuru.detail');
Route::post('/admin/nilaiGuru/store', [NilaiGuruController::class, 'store'])->name('nilaiGuru.store');

// absensi
Route::get('/admin/absensiGuru', [AbsensiGuruController::class,'index'])->name('absensiGuru.index');
Route::get('/admin/absensiGuru/detail/{id_gp}', [AbsensiGuruController::class, 'detail'])->name('absensiGuru.detail');
Route::post('/admin/absensiGuru/store', [AbsensiGuruController::class, 'store'])->name('absensiGuru.store');
Route::post('/admin/absensiGuruDetail/store', [AbsensiGuruController::class, 'storeAbsensiGuruDetail'])->name('absensiGuruDetail.store');
Route::delete('/admin/absensiGuru/destroy/{id_absensi}', [AbsensiGuruController::class, 'destroyAbsensiGuru'])->name('absensiGuru.destroy');

// laporan kuisioner
Route::get('/admin/kuisionerGuru/laporan', [KuisionerGuruController::class,'laporanKuisionerGuru'])->name('laporanKuisionerGuru.laporan');
Route::get('/admin/kuisionerGuru/detail/{id_gp}', [KuisionerGuruController::class, 'detailLaporanKuisionerGuru'])->name('laporanKuisionerGuru.detail');

// home guru
Route::get('/admin/homeGuru', [App\Http\Controllers\HomeGuruController::class, 'index'])->name('guru.home');

// data slider admin
Route::put('/admin/slider/update/{id}', [DataSliderController::class, 'update'])->name('slider.update');
Route::get('/admin/slider/create', [DataSliderController::class, 'create'])->name('slider.create');
Route::get('/admin/slider', [DataSliderController::class,'index'])->name('slider.index');
Route::get('/admin/slider/edit/{id}', [DataSliderController::class, 'edit'])->name('slider.edit');
Route::post('/slider/store', [DataSliderController::class, 'store']);
Route::get('/admin/slider/destroy/{id}', [DataSliderController::class,'destroy'])->name('slider.destroy');

// data berita admin
Route::put('/admin/berita/update/{id}', [DataBeritaController::class, 'update'])->name('berita.update');
Route::get('/admin/berita/create', [DataBeritaController::class, 'create'])->name('berita.create');
Route::get('/admin/berita', [DataBeritaController::class,'index'])->name('berita.index');
Route::get('/admin/berita/edit/{id}', [DataBeritaController::class, 'edit'])->name('berita.edit');
Route::post('/berita/store', [DataBeritaController::class, 'store']);
Route::get('/admin/berita/destroy/{id}', [DataBeritaController::class,'destroy'])->name('berita.destroy');

// berita landing page
Route::get('/berita/detail/{id}', [DataBeritaController::class,'detail'])->name('berita.detail');
Route::get('/home/berita', [LandingPageController::class,'berita'])->name('landingpage.berita');

// data brosur admin
Route::put('/admin/brosur/update/{id}', [DataBrosurController::class, 'update'])->name('brosur.update');
Route::get('/admin/brosur/create', [DataBrosurController::class, 'create'])->name('brosur.create');
Route::get('/admin/brosur', [DataBrosurController::class,'index'])->name('brosur.index');
Route::get('/admin/brosur/edit/{id}', [DataBrosurController::class, 'edit'])->name('brosur.edit');
Route::post('/brosur/store', [DataBrosurController::class, 'store']);
Route::get('/admin/brosur/destroy/{id}', [DataBrosurController::class,'destroy'])->name('brosur.destroy');

// brosur landing page
Route::get('/home/brosur', [LandingPageController::class,'brosur'])->name('landingpage.brosur');
Route::get('/unduh-brosur/{id_brosur}', [DataBrosurController::class, 'unduhBrosur'])->name('unduh.brosur');