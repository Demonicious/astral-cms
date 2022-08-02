<?php

namespace Demonicious\BladeBuilder\Controllers;

use App\Http\Controllers\Controller;
use Demonicious\BladeBuilder\Models;
use Demonicious\BladeBuilder\Models\BuilderPage;
use Illuminate\Http\Request;

class PageServiceController extends Controller
{
    public string $viewsDirectory = 'theme';

    public function __construct() {
        $this->viewsDirectory = config('astral-cms.theme')::$views;
    }

    public function homepage() {
        $page = BuilderPage::where('route', '/')->first();

        abort_if(!$page, 404);

        return view($this->viewsDirectory . '.layout', [
            'page' => $page
        ]);
    }

    public function route(?string $route) {
        $page = BuilderPage::where('route', 'LIKE', '%' . $route)->first();

        abort_if(!$page, 404);

        return view($this->viewsDirectory . '.layout', [
            'page' => $page
        ]);
    }
}
