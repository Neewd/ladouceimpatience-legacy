<?php

namespace Neewd\Newsletter\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function save(Request $request)
    {
        $path = Storage::disk('public')->putFile('images/newsletters', $request->file('image'));
        return "/storage/" . $path;
    }

    public function delete(Request $request)
    {
        return response()->json(['success' => Storage::disk('public')->delete(str_replace("/storage/", "", $request->path))]);
    }


    public function deleteMultiple(Request $request)
    {
        foreach ($request->paths as $path) {
            Storage::disk('public')->delete(str_replace("/storage/", "", $path));
        }
        return response()->json(['success' => 'Tous les fichiers ont été supprimés'], 200);
    }
}
