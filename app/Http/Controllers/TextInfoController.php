<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use Inertia\Inertia;

class TextInfoController extends Controller
{
    public function show(){

        $text_infos = DB::table('text_infos')
            ->where('id', '!=', 11) //3 teksten weglaten voor Els Cloelia
            ->where('id', '!=', 17) //De hond in de rivier
            ->where('id', '!=', 38) //Ijdelheid gestraft
            ->get();

        return Inertia::render('TextsOverview', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'text_infos' => $text_infos
        ]);

    }

    public function filter(Request $request){

        $text_infos = DB::table('text_infos')
            ->where('id', '!=', 11) //3 teksten weglaten voor Els Cloelia
            ->where('id', '!=', 17) //De hond in de rivier
            ->where('id', '!=', 38) //Ijdelheid gestraft
            ->where('text_title', 'LIKE', '%' . $request->title .'%' )
            ->where('method', 'LIKE', '%' . $request->method .'%' )
            ->where('grade', 'LIKE', '%' . $request->grade .'%' )
            ->where('author', 'LIKE', '%' . $request->author .'%' )
            ->where('work', 'LIKE', '%' . $request->work .'%' )
            ->get();

        return Inertia::render('TextsOverview', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'text_infos' => $text_infos
        ]);

    }
}
