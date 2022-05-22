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
            ->select('*')
            ->get();

        return Inertia::render('TextsOverview', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'text_infos' => $text_infos
        ]);

    }
}
