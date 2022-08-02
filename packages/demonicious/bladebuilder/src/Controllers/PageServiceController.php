<?php

namespace Demonicious\BladeBuilder\Controllers;

use App\Http\Controllers\Controller;
use Demonicious\BladeBuilder\LaravelBladeBuilder;

class PageServiceController extends Controller
{
    public function handle() {
        $builder = new LaravelBladeBuilder(config('pagebuilder'));
        $hasPageReturned = $builder->handlePublicRequest();

        if (request()->path() === '/' && ! $hasPageReturned) {
            return view('default-homepage');
        } else if(!$hasPageReturned) {
            abort(404);
        }
    }
}
