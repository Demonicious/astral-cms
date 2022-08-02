<?php

use Demonicious\BladeBuilder\Controllers\PageServiceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Demonicious\BladeBuilder\LaravelBladeBuilder;

// handle pagebuilder asset requests
Route::any( config('pagebuilder.general.assets_url') . '{any}', function() {

    $builder = new LaravelBladeBuilder(config('pagebuilder'));
    $builder->handlePageBuilderAssetRequest();

})->where('any', '.*');


// handle requests to retrieve uploaded file
Route::any( config('pagebuilder.general.uploads_url') . '{any}', function() {

    $builder = new LaravelBladeBuilder(config('pagebuilder'));
    $builder->handleUploadedFileRequest();

})->where('any', '.*');

if( ! Str::startsWith(trim(request()->path()), config('astral-cms.admin-path')) ) {
    Route::any('/',        [ PageServiceController::class, 'handle' ])->name('pagebuilder::home');
    Route::any('/{route}', [ PageServiceController::class, 'handle' ])->name('pagebuilder::route');
}
// if (config('pagebuilder.website_manager.use_website_manager')) {

//     // handle all website manager requests
//     Route::any( config('pagebuilder.website_manager.url') . '{any}', function() {

//         $builder = new LaravelBladeBuilder(config('pagebuilder'));
//         $builder->handleRequest();

//     })->where('any', '.*');

// }


// Route::any('/',        [ PageServiceController::class, 'homepage' ])->name('homepage');
// Route::any('/{route}', [ PageServiceController::class, 'route'    ])->name('route');

// if (config('pagebuilder.router.use_router')) {

//     // pass all remaining requests to the LaravelPageBuilder router
//     Route::any( '/{any}', function() {

//         $builder = new LaravelBladeBuilder(config('pagebuilder'));
//         $hasPageReturned = $builder->handlePublicRequest();

//         if (request()->path() === '/' && ! $hasPageReturned) {
//             return view('default-homepage');
//         }

        

//     })->where('any', '.*');

// }
