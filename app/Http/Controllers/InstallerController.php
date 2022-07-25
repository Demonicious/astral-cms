<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Bitflan;
use Illuminate\Support\Facades\Artisan;

class InstallerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        if( env('APP_KEY') == 'base64:oOvONYryAnjXFKlC/aSEr6yRYOVSNxoUp6YTyKQDTtg=' ) {
            Artisan::call('key:generate');
            Artisan::call('storage:link');

            return redirect('/install');
        }

        return view('install.index', [
            'name' => Bitflan::Name,
            'version' => Bitflan::Version
        ]);
    }

    public function lock() {
        return view('install.lock', [
            'name' => Bitflan::Name,
            'version' => Bitflan::Version
        ]);
    }
}