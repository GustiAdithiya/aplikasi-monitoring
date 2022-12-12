<?php

use App\Http\Controllers\Admin\AdminInstanceController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Instance\InstanceMonitoringController;
use App\Http\Controllers\Instance\InstancePackageController;
use App\Http\Controllers\Instance\InstanceParticipantController;
use App\Http\Controllers\Instance\InstanceProfileController;
use App\Http\Controllers\Instance\ParticipantExcelController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::resource('admin/instance', AdminInstanceController::class)->names('admin.instance');
    Route::get('admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::put('admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});
Route::get('instance/participant/format', [ParticipantExcelController::class, 'downloadFormat'])->name('instance.participant.format');

Route::middleware(['auth', 'user-access:instance'])->group(function () {
    Route::resource('instance/package', InstancePackageController::class)->names('instance.package');
    Route::resource('instance/participant', InstanceParticipantController::class)->names('instance.participant');
    Route::get('instance/monitoring/package', [InstanceMonitoringController::class, 'getPackage'])->name('instance.monitoring.package');
    Route::get('instance/monitoring/participant', [InstanceMonitoringController::class, 'getParticipant'])->name('instance.monitoring.participant');
    Route::get('instance/monitoring', [InstanceMonitoringController::class, 'index'])->name('instance.monitoring.index');
    Route::get('instance/profile', [InstanceProfileController::class, 'index'])->name('instance.profile');
    Route::put('instance/profile', [InstanceProfileController::class, 'update'])->name('instance.profile.update');
    Route::post('instance/participant/import', [ParticipnatExcelController::class, 'excelImport'])->name('instance.participant.import');
});
