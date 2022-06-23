<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use \stdClass;
use Inertia\Inertia;

class TextController extends Controller
{
    public function new(){

        $vocs = DB::table('vocs')
        ->select('*')
        ->orderBy('word')
        ->get();

        $part_of_speeches = DB::table('systematisches')
        ->select('*')
        ->get();

        return Inertia::render('TextInput', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'vocs' => $vocs,
            'part_of_speeches' => $part_of_speeches
            ]);
    }
}
