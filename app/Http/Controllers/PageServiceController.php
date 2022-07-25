<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageServiceController extends Controller
{
    public function homepage() {
        $page = Page::where('route', '/')->first();

        abort_if(!$page, 404);

        return view('layouts.default', [
            'page' => $page
        ]);
    }

    public function route(?string $route) {
        $page = Page::where('route', 'LIKE', '%' . $route)->first();

        abort_if(!$page, 404);

        return view('layouts.default', [
            'page' => $page
        ]);
    }
}
