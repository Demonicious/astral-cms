<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageServiceController extends Controller
{
    public string $viewsDirectory = 'theme';

    public function __construct() {
        $this->viewsDirectory = config('astral-cms.theme')::$views;
    }

    public function homepage() {
        $page = Page::where('route', '/')->first();

        abort_if(!$page, 404);

        return view($this->viewsDirectory . '.layout', [
            'page' => $page
        ]);
    }

    public function route(?string $route) {
        $page = Page::where('route', 'LIKE', '%' . $route)->first();

        abort_if(!$page, 404);

        return view($this->viewsDirectory . '.layout', [
            'page' => $page
        ]);
    }
}
