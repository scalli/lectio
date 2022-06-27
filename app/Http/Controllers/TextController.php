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

    public function save(Request $request){
        // dd($request);
        $text_info_id = DB::table('text_infos')->insertGetId([
            'text_title' => $request->text_title,
            'method'  => $request->method,
            'chapter'  => $request->chapter,
            'grade'  => $request->grade,
            'extra_info'  => $request->extra_info,
            'author'  => $request->author,
            'work'  => $request->work,
            'passage'  => $request->passage,
            'contributor' => 1
        ]);
    
        $text_words_arr = $request->text_words_arr;
        // dd($text_words_arr);

        $data = [];
        foreach ($text_words_arr as $word) {
            $helper_arr = [
                'text_info_id' => $text_info_id,
                'position' => $word["position"],
                'text_word' => $word["text_word"],
                'word_voc' => $word["word_voc"],
                'phrase_number' => $word["phrase_number"],
                'supporting_question' => $word["supporting_question"],
                'phrase_support' => $word["phrase_support"]
            ];
            array_push($data, $helper_arr);    
            
        }

        DB::table('texts')->insert($data);

        return Inertia::render('TextInput', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    
    }
}
