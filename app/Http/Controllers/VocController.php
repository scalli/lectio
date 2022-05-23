<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use \stdClass;

use Illuminate\Http\Request;
use Inertia\Inertia;

class VocController extends Controller
{
    public function show($layout, $id){

        $id = $id;
        $layout = $layout;

        $text_words = DB::table('texts')
            ->join('vocs', 'texts.word_voc', '=', 'vocs.id')
            ->select('*')
            ->where('text_info_id', '=', $id)
            ->get();

        $title = DB::table('text_infos')
            ->select('text_title')
            ->where('id', '=', $id)
            ->get();

        // dd($title[0]->text_title);
        // dd(($text_words[count($text_words)-1])->phrase_number);

        $max_index = ($text_words[count($text_words)-1])->phrase_number;
        $phrases = array_fill(1, $max_index, "");//array containing all phrases
        $voc_front = array();
        $voc_back = array();
        $voc = array();
        
        foreach($text_words as $word) {
            $index = $word->phrase_number;
            $phrases[$index] = $phrases[$index] . " " . $word->text_word;
        }

        foreach($text_words as $word) {
            // $index = $word->phrase_number;
            // $phrases[$index] = $phrases[$index] . " " . $word->text_word;
        
            $vocword_back = "";
            if($word->memorize == 1){
                $o = new stdClass();
                $o->word = $word->word;
                $o->id = $word->id;
                $o->phrase_number = $word->phrase_number;
                //TODO
                $o->phrase = "";
                if($o->phrase_number>1){
                    $o->phrase = $o->phrase . $phrases[$o->phrase_number-1];
                }
                $o->phrase = $o->phrase . $phrases[$o->phrase_number];
                if($o->phrase_number != count($phrases)){
                    $o->phrase = $o->phrase . $phrases[$o->phrase_number+1];
                }
                // array_push($voc_front, $o );

                if($word->wordinfo1 != null && str_starts_with($word->wordinfo1, '+')){
                    $o->word = $o->word . ' + ';
                }
                if($word->wordinfo1 != null && !str_starts_with($word->wordinfo1, '+')){
                    $vocword_back = $vocword_back . $word->wordinfo1;
                    $o->word = $o->word . ', ';
                }
                elseif($word->wordinfo1 != null){
                    $vocword_back = $vocword_back . $word->wordinfo1;
                }
                if($word->wordinfo2 != null){
                    $vocword_back = $vocword_back . ', ' . $word->wordinfo2;
                }
                if($word->wordinfo3 != null){
                    $vocword_back = $vocword_back . ', ' . $word->wordinfo3;
                }
                 if($word->wordinfo4 != null){
                    $vocword_back = $vocword_back . ', ' . $word->wordinfo4;
                }
                
                $vocword_back = $vocword_back . ': ';

                if($word->meaning1 != null){
                    $vocword_back = $vocword_back . $word->meaning1;
                }
                if($word->meaning2 != null){
                    $vocword_back = $vocword_back . ', ' . $word->meaning2;
                }
                if($word->meaning3 != null){
                    $vocword_back = $vocword_back . ', ' . $word->meaning3;
                }
                 if($word->meaning4 != null){
                    $vocword_back = $vocword_back . ', ' . $word->meaning4;
                }

                if($word->parentheses != null){
                    $vocword_back = $vocword_back . ' (' . $word->parentheses . ' )';
                }

                $o->back = $vocword_back;
                $o->attempts = 0;
                $o->corrects = 0;

                // array_push($voc_back, $vocword_back);

                array_push($voc, $o );
            }//end of if memorize

        }//end of foreach $word

        // dd($voc_front);
        // dd($voc_back);


        if($layout == "quick"){
            $page_to_render = 'VocQuick';
        }
        if($layout == "profound"){
            $page_to_render = 'VocProfound';
        }

        return Inertia::render($page_to_render, [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'title' => $title[0]->text_title,
        'phrases' => $phrases,
        'voc' => $voc
        // 'voc_front' => $voc_front,
        // 'voc_back' => $voc_back
        ]);
    }
}
