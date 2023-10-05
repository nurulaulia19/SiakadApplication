<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jasa;
use App\Models\Cabang;
use App\Models\DataUser;
use App\Models\Kategori;
use App\Models\RoleMenu;
use App\Models\Data_Menu;
use App\Models\Transaksi;
use App\Models\DataProduk;
use App\Models\AksesCabang;
use App\Models\Verifytoken;
use Illuminate\Http\Request;
use App\Models\AditionalProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // $startDate = Carbon::now()->startOfMonth();
        // $endDate = Carbon::now()->endOfMonth();

        // $labels = [];
        // $currentDate = $startDate->copy();
        // while ($currentDate <= $endDate) {
        //     $labels[] = $currentDate->format('d M Y');
        //     $currentDate->addDay();
        // }

        // $loggedInUser = auth()->user();
        // $dataCabang = AksesCabang::where('user_id', $loggedInUser->user_id)->get();
        // $cabangIds = $dataCabang->pluck('cabang.id_cabang')->toArray();

        // $dataPerCabang = [];
        // $namaCabang = Cabang::whereIn('id_cabang', $cabangIds)
        //     ->pluck('nama_cabang', 'id_cabang')
        //     ->toArray();

        // // Jika user memiliki akses ke cabang tertentu, ambil hanya cabang yang dimilikinya
        // if (!empty($cabangIds)) {
        //     foreach ($cabangIds as $cabangId) {
        //         $totals = [];

        //         foreach ($labels as $label) {
        //             $tanggal = Carbon::createFromFormat('d M Y', $label)->format('Y-m-d');

        //             $transaksi = Transaksi::where('id_cabang', $cabangId)
        //                 ->where('user_id', $loggedInUser->user_id)
        //                 ->whereDate('tanggal_transaksi', $tanggal)
        //                 ->count();

        //             $totals[] = $transaksi;
        //         }

        //         $dataPerCabang[$cabangId] = $totals;
        //     }
        // } else {
        //     // Jika user tidak memiliki akses cabang, hitung transaksi untuk semua cabang
        //     $allCabangIds = Cabang::pluck('id_cabang')->toArray();

        //     foreach ($allCabangIds as $cabangId) {
        //         $totals = [];

        //         foreach ($labels as $label) {
        //             $tanggal = Carbon::createFromFormat('d M Y', $label)->format('Y-m-d');

        //             $transaksi = Transaksi::where('id_cabang', $cabangId)
        //                 ->whereDate('tanggal_transaksi', $tanggal)
        //                 ->count();

        //             $totals[] = $transaksi;
        //         }

        //         $dataPerCabang[$cabangId] = $totals;

        //         // Tambahkan nama cabang jika tidak ada di $namaCabang (user_id tidak punya akses id_cabang)
        //         if (!isset($namaCabang[$cabangId])) {
        //             $namaCabang[$cabangId] = Cabang::where('id_cabang', $cabangId)->value('nama_cabang');
        //         }
        //     }
        // }


        // $jumlahJasa = Jasa::count();
        // $jumlahKategori = Kategori::count();

        // $loggedInUser = auth()->user();
        // $dataCabang = AksesCabang::where('user_id', $loggedInUser->user_id)->get();
        // $hasAccessToCabang = $dataCabang->isNotEmpty();

        // $today = now();
        // $month = $today->month;
        

        // if ($hasAccessToCabang) {
        //     $user_id = $loggedInUser->user_id;
        //     $totalHargaProduk = Transaksi::where('user_id', $user_id)->whereMonth('created_at', $month)->sum('total_harga');
        //     $jumlahTransaksi = Transaksi::where('user_id', $user_id)->whereMonth('created_at', $month)->count();
        // } else {
        //     $totalHargaProduk = Transaksi::whereMonth('created_at', $month)->sum('total_harga');
        //     $jumlahTransaksi = Transaksi::whereMonth('created_at', $month)->count();
        // }

        
        
        // MENU

        $user_id = auth()->user()->user_id;
        $user = DataUser::findOrFail($user_id);
        $menu_ids = $user->role->roleMenus->pluck('menu_id');
       
        $menu_route_name = request()->route()->getName(); // Nama route dari URL yang diminta
    
        // Ambil menu berdasarkan menu_link yang sesuai dengan nama route
        $requested_menu = Data_Menu::where('menu_link', $menu_route_name)->first();
        // dd($requested_menu);
    
        // Periksa izin akses berdasarkan menu_id dan user_id
        if (!$requested_menu || !$menu_ids->contains($requested_menu->menu_id)) {
            return redirect()->back()->with('error', 'You do not have permission to access this menu.');
        }

        $mainMenus = Data_Menu::where('menu_category', 'master menu')
            ->whereIn('menu_id', $menu_ids)
            ->get();

        $menuItemsWithSubmenus = [];

        foreach ($mainMenus as $mainMenu) {
            $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                ->where('menu_category', 'sub menu')
                ->whereIn('menu_id', $menu_ids)
                ->orderBy('menu_position')
                ->get();

            $menuItemsWithSubmenus[] = [
                'mainMenu' => $mainMenu,
                'subMenus' => $subMenus,
            ];
        }
    



        return view('home.index', compact('menuItemsWithSubmenus'));
    
        // return view('home.index', compact('labels', 'dataPerCabang', 'jumlahTransaksi', 'jumlahJasa', 'jumlahKategori', 'totalHargaProduk','namaCabang','menuItemsWithSubmenus'));
        // return view('home.index');

    //     $get_user = User::where('email',auth()->user()->email)->first();
    //     if($get_user->is_activated == 1){
    //         return view('home');
    //     }else{
    //         return redirect('/verify-account');
    //     }
        
    // }

    // public function verifyaccount(){
    //     return view('opt_verification');
    }

    // public function useractivation(Request $request){
    //     $get_token = $request->token;
    //     $get_token = Verifytoken::where('token',$get_token)->first();

    //     if($get_token){
    //         $get_token->is_activated = 1;
    //         $get_token->save();
    //         $user = User::where('email',$get_token->email)->first();
    //         $user->is_activated = 1;
    //         $user->save();
    //         $getting_token = Verifytoken::where('token',$get_token->token)->first();
    //         // $getting_token->delete();
    //         return redirect('/home')->with('activated','Your Account has been activated successfully');
    //     } else{
    //         return redirect('/verify-account')->with('incorrect','Your OTP is invalid please check your email once');
    //     }
    // }

    // public function showSidebar()
    // {
    //     $dataMenu = Data_Menu::with('submenus')->get();
    //     return view('layouts.sidebar2', compact('dataMenu'));
    // }
    
}
