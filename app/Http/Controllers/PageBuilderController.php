<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PageBuilderController extends Controller
{
    public function builder(Page $page) {
        $assets = $page->uploads;
        $assets = $assets && count($assets) ? json_encode($assets->map(fn($asset) => asset( 'storage/media/' . $asset->name ))) : '[]';

        return view('builder', [
            'page'   => $page,
            'assets' => $assets
        ]);
    }

    public function store(Request $request, Response $response, Page $page) {
        $validated = $this->validate($request, [
            'data' => 'required',
        ]);

        $page->fill($request->all());

        $page->save();

        File::put(storage_path('app/public/styles/' . md5($page->created_at) . '.css'), $page->css);
        File::put(storage_path('app/public/scripts/' . md5($page->created_at) . '.js'), $page->js);

        return $response->status(200);
    }

    public function upload(Request $request, Page $page) {
        if($request->hasFile('files') && is_array($request->file('files'))) {
            $files = [];

            foreach($request->file('files') as $file) {
                $name = md5($file->getClientOriginalName() . now()->format('M d, Y')) . '.' . $file->getClientOriginalExtension();
            
                Storage::put('public/media/' . $name, file_get_contents($file));

                $files[] = asset('storage/media/' . $name);

                $upload = new Upload();
                $upload->page_id = $page->id;
                $upload->name    = $name;
                $upload->save();
            }

            return response()->json([
                'data' => $files
            ]);
        }

        abort(400);
    }

    public function extensions() {
        
    }
}
