<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\GambarController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanDetailController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReportPengembalian;
use App\Http\Controllers\DeleteAllController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [HomeController::class, 'index']);

// Route::resource('home', FrontendController::class);
Route::resource('svpeminjaman', HomeController::class);

Route::resource('/', FrontendController::class);
Route::get('/home/kategori',[FrontendController::class, 'getkategori'] );
Route::get('home/getbarang',[FrontendController::class, 'getbarang']);
Route::get('home/caribarang/{merk}', [FrontendController::class, 'cariBarang']);
Route::get('home/carianggota/{userId}', [FrontendController::class, 'cariAnggota']);
Route::get('daftaranggota',[FrontendController::class, 'daftarAnggota'])->name('daftaranggota');
Route::get('getKelas',[FrontendController::class, 'getkelas']);
Route::post('svanggota',[FrontendController::class, 'storeAnggota'])->name('svanggota');
Route::get('/home/getanggotaid/{id}', [FrontendController::class, 'getanggotaid']);
Route::get('getpeminjamans/{id}',[FrontendController::class, 'getPeminjaman']);
Route::get('/peminjamanku',[FrontendController::class, 'indexPeminjamanku' ]);
Route::post('savepeminjamandetail', [FrontendController::class, 'storeDetail']);
Route::get('home/getpeminjam', [FrontendController::class, 'getPeminjam']);
Route::post('svccpeminjaman', [FrontendController::class, 'storeCc']);
Route::get('lihat/{id}/cc', [FrontendController::class, 'Cc']);

Route::resource('anggota', AnggotaController::class);
Route::get('getanggota',[AnggotaController::class, 'getanggota']);
Route::post('saveanggota', [AnggotaController::class, 'store'] )->name('saveanggota');
Route::get('hapusanggota/{id}', [AnggotaController::class, 'destroy'] )->name('hapusanggota');
Route::post('ubahanggota/{id}', [AnggotaController::class, 'update'] )->name('ubahanggota');
Route::get('carianggota/{anggota}', [AnggotaController::class, 'cariAnggota']);

Route::get('getuser',[AnggotaController::class, 'getuser']);
Route::get('getkelas',[AnggotaController::class, 'getkelas']);

Route::resource('barang', BarangController::class);
Route::get('getbarang', [BarangController::class, 'getBarang']);
Route::get('getkategori', [BarangController::class, 'getKategori']);
Route::get('caribarang/{merk}', [BarangController::class, 'cariBarang']);
Route::get('hapusbarang/{id}', [BarangController::class, 'destroy'] )->name('hapusanggota');
Route::post('savebarang', [BarangController::class, 'store'] )->name('savebarang');
Route::post('ubahbarang/{id}', [BarangController::class, 'update'] )->name('ubahbarang');
Route::delete('barangDeleteAll', [BarangController::class, 'deleteAll']);

Route::resource('peminjamandetail', PeminjamanController::class);
Route::get('getpeminjaman',[PeminjamanController::class, 'getPeminjaman']);
Route::get('hapuspeminjaman/{id}', [PeminjamanController::class, 'destroy'] )->name('hapuspeminjaman');
Route::get('getpeminjam',[PeminjamanController::class, 'getPeminjam']);
Route::post('svpeminjamandetail', [PeminjamanController::class, 'storeDetail']);
Route::get('caripeminjaman/{peminjaman}', [PeminjamanController::class, 'cariPeminjaman']);
Route::get('lihat/{id}/anggota', [PeminjamanController::class, 'lihatCc']);
Route::delete('peminjamanDelete/{id}', [PeminjamanController::class, 'peminjamanDelete']);
Route::delete('peminjamanDeleteAll', [PeminjamanController::class, 'deleteAll']);
// Route::post('savepeminjamandetail', [PeminjamanController::class, 'store']);

Route::resource('admin/pengembalian', PengembalianController::class);
Route::get('admin/getpengembalian', [PengembalianController::class, 'getpeminjaman']);
Route::get('admin/getdatapeminjaman',[PengembalianController::class, 'getdatapeminjaman']);
Route::get('admin/caridatapeminjaman/{peminjaman}', [PengembalianController::class, 'caridataPeminjaman']);
Route::post('admin/ubahstatus/{id}', [PengembalianController::class, 'ubahStatus']);

Route::resource('admin/user', UserController::class)->middleware('is_admin');;
Route::get('admin/getuser', [UserController::class, 'getuser']);
Route::post('admin/saveuser', [UserController::class, 'store'] )->name('saveuser');
Route::get('admin/cariuser/{anggota}', [UserController::class, 'cariAnggota']);
Route::get('admin/hapususer/{id}', [UserController::class, 'destroy'] )->name('hapususer');
Route::post('admin/ubahuser/{id}', [UserController::class, 'update'] )->name('ubahuser');
Route::get('admin/user/{id}/change', [UserController::class, 'change']);

Route::resource('kelas', KelasController::class);
Route::get('getkelas', [KelasController::class, 'getKelas']);
Route::post('savekelas', [KelasController::class, 'store'])->name('savekelas');
Route::get('hapuskelas/{id}', [KelasController::class, 'destroy'] )->name('hapuskelas');
Route::post('ubahkelas/{id}', [KelasController::class, 'update'] )->name('ubahkelas');
Route::get('carikelas/{kelas}', [KelasController::class, 'cariKelas']);

Route::resource('kategori', KategoriController::class);
Route::get('getkategori', [KategoriController::class, 'getKategori']);
Route::post('savekategori', [KategoriController::class, 'store'])->name('savekategori');
Route::get('hapuskategori/{id}', [KategoriController::class, 'destroy'] )->name('hapuskategori');
Route::post('ubahkategori/{id}', [KategoriController::class, 'update'] )->name('ubahkategori');
Route::get('carikategori/{kategori}', [KategoriController::class, 'cariKategori']);
Route::delete('myproductsDeleteAll', [KategoriController::class, 'deleteAll']);

Route::resource('admin/report/pengembalian',ReportPengembalian::class);
Route::get('admin/report/cetakpdf',[ReportPengembalian::class, 'report']);
// Route::get('admin/report/pengembalian',[ReportPengembalian::class, 'index']);
Route::get('admin/export/pengembalian',[ReportPengembalian::class, 'export']);

Route::get('myproducts', [DeleteAllController::class, 'index']);


Auth::routes();
