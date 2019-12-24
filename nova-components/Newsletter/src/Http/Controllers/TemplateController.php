<?php

namespace Neewd\Newsletter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Debugbar;

class TemplateController extends Controller
{
    
    public function index(Request $request)
    {
        $templateFilles = Storage::disk('views')->files("./newsletters");
        $templates = [];

        for ($i = 0; $i < sizeof($templateFilles); $i++) {
            $viewName = str_replace('.blade.php', '', $templateFilles[$i]);
            $file = file_get_contents(base_path() . '/resources/views/' . $templateFilles[$i], true);
            $view = new \stdClass();
            $view->path = $viewName;
            $view->name = str_replace('newsletters/', '', $viewName);
            $view->html = $file;
            array_push($templates, $view);

        }
        return response()->json(['templates' => $templates], $this->successStatus);
    }

    public function get(Request $request)
    {
        $viewFile = view("newsletters/" . $request->name);
        $htmlView = $viewFile->render();
        $view = new \stdClass();
        $view->path = "newsletters/" . $request->name . ".txt";
        $view->name = $request->name;
        $view->html = $htmlView;

        return response()->json(['template' => $view], $this->successStatus);
    }

    public function delete(Request $request)
    {
        $deleteSuccess = Storage::disk('views')->delete("./newsletters/" . $request->name . ".txt");

        return response()->json(['returnCode' => $deleteSuccess]);
    }

    public function save(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'content'   => 'required'
        );
        $messages = [
            'name.required' => "Un nom pour ce joli template ?",
            'content.required' => "Il manque un contenu peut être ?"
        ];

        $this->validate($request, $rules, $messages);
        $fileName =  $this->slugify($request->name) . '.txt';
        $filePath =  base_path() . '/resources/views/newsletters/' . $fileName;
        file_put_contents($filePath, $request->content, LOCK_EX);
        return response()->json(['message' => 'Le template s\'est bien sauvegardé.'], $this->successStatus);
    }

    private function slugify($string, $delimiter = '-')
    {
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }
}
