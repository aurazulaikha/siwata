<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProposalTaController;
use App\Http\Controllers\ProposalStatusController;
use App\Http\Controllers\SidangProposalController;
use App\Http\Controllers\DokumenSidangController;
use App\Http\Controllers\SidangTaController;
use App\Http\Controllers\NilaiKetuaController;
use App\Http\Controllers\NilaiSekretarisController;
use App\Http\Controllers\NilaiPembimbing1Controller;
use App\Http\Controllers\NilaiPembimbing2Controller;
use App\Http\Controllers\NilaiPenguji1Controller;
use App\Http\Controllers\NilaiPenguji2Controller;
use App\Http\Controllers\NilaiTaController;
use App\Http\Controllers\WelcomeController;
use App\Models\NilaiTa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WelcomeController::class, 'index']);

Auth::routes(['verify' => true]);
Route::get('/email/verify', function () {
    return view('auth.verify');
})->name('verification.notice');




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile');
    Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('update.profile');
    Route::get('/edit-password', [UserController::class, 'editPassword'])->name('ubah-password');
    Route::patch('/update-password', [UserController::class, 'updatePassword'])->name('update-password');
});

Route::group(['middleware' => ['auth', 'checkRole:dosen']], function () {
    Route::get('/dosen/dashboard', [HomeController::class, 'dosen'])->name('dosen.dashboard');
    Route::resource('proposalTa', ProposalTaController::class);
    Route::get('/proposal-ta/pembimbing1', [ProposalTaController::class, 'indexForDosen1'])->name('proposalTa.indexForDosen1');
    Route::get('/proposal-ta/pembimbing2', [ProposalTaController::class, 'indexForDosen2'])->name('proposalTa.indexForDosen2');
    Route::post('/proposal-ta/dosen/verify/1{id}', [ProposalTaController::class, 'statusProposal1'])->name('proposalTa.status1');
    Route::post('/proposal-ta/dosen/verify/2{id}', [ProposalTaController::class, 'statusProposal2'])->name('proposalTa.status2');
    Route::post('/proposal-ta/{id}/pembimbing/comment', [ProposalTaController::class, 'saveComment'])->name('proposalTa.comment');
    Route::get('/jadwal/pembimbing1', [SidangProposalController::class, 'indexForPem1'])->name('jadwal.pem1');
    Route::get('/jadwal/pembimbing2', [SidangProposalController::class, 'indexForPem2'])->name('jadwal.pem2');
    Route::get('/jadwal/penguji', [SidangProposalController::class, 'indexForPenguji'])->name('jadwal.penguji');

    Route::get('/dokumen-sidang/pembimbing1', [DokumenSidangController::class, 'indexForDosen1'])->name('dokumenSidang.indexForDosen1');
    Route::get('/dokumen-sidang/pembimbing2', [DokumenSidangController::class, 'indexForDosen2'])->name('dokumenSidang.indexForDosen2');
    Route::post('/dokumen-sidang/dosen/verify1/{id}', [DokumenSidangController::class, 'statusProposal1'])->name('dokumenSidang.status1');
    Route::post('/dokumen-sidang/dosen/verify2/{id}', [DokumenSidangController::class, 'statusProposal2'])->name('dokumenSidang.status2');
    Route::post('/dokumen-sidang/{id}/pembimbing/comment', [DokumenSidangController::class, 'saveComment'])->name('dokumenSidang.comment');

    Route::get('/jadwal/ketua', [SidangTaController::class, 'indexForKetua'])->name('jadwalTa.ketua');
    Route::get('/jadwal/sekretaris', [SidangTaController::class, 'indexForSekretaris'])->name('jadwalTa.sekretaris');
    Route::get('/jadwal/penguji1', [SidangTaController::class, 'indexForPenguji1'])->name('jadwalTa.penguji1');
    Route::get('/jadwal/penguji2', [SidangTaController::class, 'indexForPenguji2'])->name('jadwalTa.penguji2');

    Route::get('/nilai-ta/ketua', [NilaiKetuaController::class, 'index'])->name('sidangTa.ketua');
    Route::get('/nilai/ketua/{id}', [NilaiKetuaController::class, 'nilai'])->name('nilaiTa.ketua');
    Route::get('/nilaiKetua/create/{sidang_ta_id}', [NilaiKetuaController::class, 'create'])->name('nilaiKetua.create');
    Route::put('/nilaiKetua/{sidang_ta_id}', [NilaiKetuaController::class, 'store'])->name('nilaiKetua.store');
    Route::get('/nilai-ketua/{id}/edit', [NilaiKetuaController::class, 'edit'])->name('nilaiKetua.edit');
    Route::put('nilai-Ketua/{id}', [NilaiKetuaController::class, 'update'])->name('nilaiKetua.update');

    Route::get('/sidang/pembimbing1', [NilaiPembimbing1Controller::class, 'index'])->name('sidangTa.pembimbing1');
    Route::get('/nilai/pembimbing1/{id}', [NilaiPembimbing1Controller::class, 'nilai'])->name('nilaiTa.pembimbing1');
    Route::get('/nilaiPembimbing1/create/{sidang_ta_id}', [NilaiPembimbing1Controller::class, 'create'])->name('nilaiPembimbing1.create');
    Route::put('/nilaiPembimbing1/{sidang_ta_id}', [NilaiPembimbing1Controller::class, 'store'])->name('nilaiPembimbing1.store');
    Route::get('/nilai-Pembimbing1/{id}/edit', [NilaiPembimbing1Controller::class, 'edit'])->name('nilaiPembimbing1.edit');
    Route::put('nilai-Pembimbing1/{id}', [NilaiPembimbing1Controller::class, 'update'])->name('nilaiPembimbing1.update');

    Route::get('/sidang/pembimbing2', [NilaiPembimbing2Controller::class, 'index'])->name('sidangTa.pembimbing2');
    Route::get('/nilai/pembimbing2/{id}', [NilaiPembimbing2Controller::class, 'nilai'])->name('nilaiTa.pembimbing2');
    Route::get('/nilaiPembimbing2/create/{sidang_ta_id}', [NilaiPembimbing2Controller::class, 'create'])->name('nilaiPembimbing2.create');
    Route::put('/nilaiPembimbing2/{sidang_ta_id}', [NilaiPembimbing2Controller::class, 'store'])->name('nilaiPembimbing2.store');
    Route::get('/nilai-Pembimbing2/{id}/edit', [NilaiPembimbing2Controller::class, 'edit'])->name('nilaiPembimbing2.edit');
    Route::put('nilai-Pembimbing2/{id}', [NilaiPembimbing2Controller::class, 'update'])->name('nilaiPembimbing2.update');

    Route::get('/sidang/sekretaris', [NilaiSekretarisController::class, 'index'])->name('sidangTa.sekretaris');
    Route::get('/nilai/sekretaris/{id}', [NilaiSekretarisController::class, 'nilai'])->name('nilaiTa.sekretaris');
    Route::get('/nilaiSekretaris/create/{sidang_ta_id}', [NilaiSekretarisController::class, 'create'])->name('nilaiSekretaris.create');
    Route::put('/nilaiSekretaris/{sidang_ta_id}', [NilaiSekretarisController::class, 'store'])->name('nilaiSekretaris.store');
    Route::get('/nilai-Sekretaris/{id}/edit', [NilaiSekretarisController::class, 'edit'])->name('nilaiSekretaris.edit');
    Route::put('nilai-Sekretaris/{id}', [NilaiSekretarisController::class, 'update'])->name('nilaiSekretaris.update');

    Route::get('/sidang/penguji1', [NilaiPenguji1Controller::class, 'index'])->name('sidangTa.penguji1');
    Route::get('/nilai/penguji1/{id}', [NilaiPenguji1Controller::class, 'nilai'])->name('nilaiTa.penguji1');
    Route::get('/nilaiPenguji1/create/{sidang_ta_id}', [NilaiPenguji1Controller::class, 'create'])->name('nilaiPenguji1.create');
    Route::put('/nilaiPenguji1/{sidang_ta_id}', [NilaiPenguji1Controller::class, 'store'])->name('nilaiPenguji1.store');
    Route::get('/nilai-Penguji1/{id}/edit', [NilaiPenguji1Controller::class, 'edit'])->name('nilaiPenguji1.edit');
    Route::put('nilai-Penguji1/{id}', [NilaiPenguji1Controller::class, 'update'])->name('nilaiPenguji1.update');

    Route::get('/sidang/penguji2', [NilaiPenguji2Controller::class, 'index'])->name('sidangTa.penguji2');
    Route::get('/nilai/penguji2/{id}', [NilaiPenguji2Controller::class, 'nilai'])->name('nilaiTa.penguji2');
    Route::get('/nilaiPenguji2/create/{sidang_ta_id}', [NilaiPenguji2Controller::class, 'create'])->name('nilaiPenguji2.create');
    Route::put('/nilaiPenguji2/{sidang_ta_id}', [NilaiPenguji2Controller::class, 'store'])->name('nilaiPenguji2.store');
    Route::get('/nilai-Penguji2/{id}/edit', [NilaiPenguji2Controller::class, 'edit'])->name('nilaiPenguji2.edit');
    Route::put('nilai-Penguji2/{id}', [NilaiPenguji2Controller::class, 'update'])->name('nilaiPenguji2.update');

    Route::get('/sidang/nilai-ta', [NilaiTaController::class, 'indexForDosen'])->name('sidangTa.nilaiDosen');
    Route::get('/nilai-tampil/{id}', [NilaiTaController::class, 'nilaiDosen'])->name('nilaiTa.Dosen');








});

Route::group(['middleware' => ['auth', 'checkRole:mahasiswa']], function () {
    Route::get('/mahasiswa/dashboard', [HomeController::class, 'mahasiswa'])->name('mahasiswa.dashboard');
    Route::resource('proposalTa', ProposalTaController::class);
    Route::get('/proposal-TA', [ProposalTaController::class, 'index'])->name('proposalTa.index');
    Route::resource('statusProposalTa', ProposalStatusController::class);
    Route::post('/proposalTa/pem1', [ProposalTaController::class, 'pem1'])->name('proposalTa.pem1');
    Route::post('/proposalTa/pem2', [ProposalTaController::class, 'pem2'])->name('proposalTa.pem2');
    Route::get('/jadwal/sidangProposal', [SidangProposalController::class, 'indexForMahasiswa'])->name('jadwal.mahasiswa');

    Route::resource('dokumenSidang', DokumenSidangController::class);
    Route::get('/dokumen-sidang', [DokumenSidangController::class, 'index'])->name('dokumenSidang.index');
    Route::get('/dokumen-sidang/stattus', [DokumenSidangController::class, 'dokumenStatusMahasiswa'])->name('dokumenSidang.status');
    Route::get('/jadwal/sidangTa', [SidangTaController::class, 'indexForMahasiswa'])->name('jadwalTa.mahasiswa');

    Route::get('/sidang/mahasiswa', [NilaiTaController::class, 'index'])->name('sidangTa.mahasiswa');
    Route::get('/nilai/mahasiswa/{id}', [NilaiTaController::class, 'nilai'])->name('nilaiTa.mahasiswa');


});

Route::group(['middleware' => ['auth', 'checkRole:kaprodi']], function () {
    Route::get('/kaprodi/dashboard', [HomeController::class, 'kaprodi'])->name('kaprodi.dashboard');
    Route::get('/proposalTa', [ProposalTaController::class, 'indexForKaprodi'])->name('proposalTa.IndexForKaprodi');
    Route::post('/kaprodi/proposalTa/{id}/verify', [ProposalTaController::class, 'verifyProposal'])->name('kaprodi.verifyProposal');
    Route::post('/proposal-ta/{id}/kaprodi/comment', [ProposalTaController::class, 'commentKaprodi'])->name('proposalTa.commentKaprodi');
    Route::resource('sidang_proposal', SidangProposalController::class);

    Route::get('/dokumenSidang', [DokumenSidangController::class, 'indexForKaprodi'])->name('dokumenSidang.IndexForKaprodi');
    Route::post('/kaprodi/dokumenSidang/{id}/verify', [DokumenSidangController::class, 'verifyProposal'])->name('kaprodi.verifyDokumen');
    Route::post('/dokumen-sidang/{id}/kaprodi/comment', [DokumenSidangController::class, 'commentKaprodi'])->name('dokumenSidang.commentKaprodi');
    Route::resource('sidang_ta', SidangTaController::class);

    Route::get('/sidang/nilai', [NilaiTaController::class, 'indexForKaprodi'])->name('sidangTa.nilaiKaprodi');
    Route::get('/nilai/{id}', [NilaiTaController::class, 'nilaiKaprodi'])->name('nilaiTa.kaprodi');

    Route::get('/daftar-mahasiswa', [MahasiswaController::class, 'indexKaprodi'])->name('mahasiswa.kaprodi');
    Route::get('/daftar-mahasiswa/{id}', [MahasiswaController::class, 'showKaprodi'])->name('mahasiswa.kaprodiShow');

    Route::get('/daftar-dosen', [DosenController::class, 'indexKaprodi'])->name('dosen.kaprodi');
    Route::get('/daftar-dosen/{id}', [DosenController::class, 'showKaprodi'])->name('dosen.kaprodiShow');

    Route::get('/daftar-ruangan', [RuanganController::class, 'indexKaprodi'])->name('ruangan.kaprodi');
    Route::get('/daftar-sesi', [SesiController::class, 'indexKaprodi'])->name('sesi.kaprodi');


    Route::get('/reports', [NilaiTaController::class, 'report'])->name('report.sidang');
    Route::get('/report-nilai', [NilaiTaController::class, 'reportNilai'])->name('report.nilai');
    Route::get('/report-status', [NilaiTaController::class, 'reportStatus'])->name('report.status');
    Route::get('/report-penguji', [NilaiTaController::class, 'reportPenguji'])->name('report.penguji');


});

Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
    Route::get('/admin/dashboard', [HomeController::class, 'admin'])->name('admin.dashboard');
    Route::resource('kaprodi', KaprodiController::class);
    Route::resource('prodi', ProdiController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('ruangan', RuanganController::class);
    Route::resource('sesi', SesiController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('userAdmin', UserController::class);
    Route::resource('jadwal', JadwalController::class);

    Route::get('/daftarTa', [DokumenSidangController::class, 'indexForAdmin'])->name('dokumenSidang.IndexForAdmin');


    Route::get('/jadwal-ta', [SidangTaController::class, 'indexForAdmin'])->name('jadwalTa.IndexForAdmin');
    Route::get('/jadwal-ta/{id}', [SidangTaController::class, 'editAdmin'])->name('jadwalTa.editAdmin');
    Route::put('jadwal-ta/{id}', [SidangTaController::class, 'updateAdmin'])->name('jadwalTa.updateAdmin');
    Route::post('/jadwal-ta/tambah', [SidangTaController::class, 'storeAdmin'])->name('jadwalTa.storeAdmin');
    Route::delete('/jadwal-ta/{id}/destroy', [SidangTaController::class, 'destroyAdmin'])->name('jadwalTa.destroyAdmin');

    Route::get('/nilai-ta', [NilaiTaController::class, 'indexForAdmin'])->name('sidangTa.nilaiAdmin');
    Route::get('/nilai-ta/{id}', [NilaiTaController::class, 'nilaiAdmin'])->name('nilaiTa.admin');



    Route::get('export_dosen', [DosenController::class, 'export_dosen'])->name('export_dosen');
    Route::post('import_dosen', [DosenController::class, 'import_dosen'])->name('import_dosen');
    Route::get('export_user', [UserController::class, 'export_user'])->name('export_user');
    Route::post('import_user', [UserController::class, 'import_user'])->name('import_user');
    Route::get('export_mahasiswa', [MahasiswaController::class, 'export_mahasiswa'])->name('export_mahasiswa');
    Route::post('import_mahasiswa', [MahasiswaController::class, 'import_mahasiswa'])->name('import_mahasiswa');

    Route::get('/report/Admin', [NilaiTaController::class, 'reportAdmin'])->name('report.sidangAdmin');
    Route::get('/report-nilai/Admin', [NilaiTaController::class, 'reportNilaiAdmin'])->name('report.nilaiAdmin');
    Route::get('/report-status/Admin', [NilaiTaController::class, 'reportStatusAdmin'])->name('report.statusAdmin');
    Route::get('/report-penguji/Admin', [NilaiTaController::class, 'reportPengujiAdmin'])->name('report.pengujiAdmin');
});

Route::middleware(['auth', 'check_permissions:edit'])->group(function () {
    Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/admin/users/update/{id}', [UserController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'check_permissions:delete'])->group(function () {
    Route::delete('/admin/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});


