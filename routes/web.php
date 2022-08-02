<?php
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\PageServiceController;
use App\Http\Controllers\PageBuilderController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\File;
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

if( File::exists( storage_path('bitflan/installed.stp') ) ) {

    Route::prefix(config('filament.path'))->middleware([Authenticate::class])->group(function() {

        // Route::get('/astral-page-builder/{page:id}',  [ PageBuilderController::class, 'builder'    ])->name('page-builder-edit');
        // Route::put('/astral-page-builder/{page:id}',  [ PageBuilderController::class, 'store'      ])->name('page-builder-store');
        // Route::post('/astral-page-builder/{page:id}', [ PageBuilderController::class, 'upload'     ])->name('page-builder-upload');
        // Route::get('/astral-page-builder-extensions', [ PageBuilderController::class, 'extensions' ])->name('page-builder-extensions');

    });

    // Route::get('/',        [ PageServiceController::class, 'homepage' ])->name('homepage');
    // Route::get('/{route}', [ PageServiceController::class, 'route'    ])->name('route');
} else {
    Route::get('/', function() {
        return redirect(route('installer'));
    });

    Route::get('/install', [ InstallerController::class, 'index' ])->name('installer');
}