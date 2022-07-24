<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use Inertia\Inertia;


class ReadTextController extends Controller
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
        $questions = array_fill(1, $max_index, "");//array containing all supporting questions per phrase
        $voc = array_fill(1, $max_index, []);//array containing all voc per phrase
        $phrase_supports = array_fill(1, $max_index, "");//array containing all support per phrase
        
        foreach($text_words as $word) {
            // console.log($word);
            $index = $word->phrase_number;

            $phrases[$index] = $phrases[$index] . " " . $word->text_word;
            if($word->supporting_question != null){
                $questions[$index] = $questions[$index] . $word->supporting_question;
            }
            if($word->phrase_support != null){
                $phrase_supports[$index] = $phrase_supports[$index] . $word->phrase_support;
            }
        
            $vocword = "";
            if($word->memorize == 1){
                $vocword = "* " . $vocword;
            }
            $vocword = $vocword . $word->word;
            if($word->wordinfo1 != null && !str_starts_with($word->wordinfo1, '+')){
                $vocword = $vocword . ',' . $word->wordinfo1;
            }
            elseif($word->wordinfo1 != null){
                $vocword = $vocword . $word->wordinfo1;
            }
            if($word->wordinfo2 != null){
                $vocword = $vocword . ', ' . $word->wordinfo2;
            }
            if($word->wordinfo3 != null){
                $vocword = $vocword . ', ' . $word->wordinfo3;
            }
             if($word->wordinfo4 != null){
                $vocword = $vocword . ', ' . $word->wordinfo4;
            }
            
            $vocword = $vocword . ': ';

            if($word->meaning1 != null){
                $vocword = $vocword . $word->meaning1;
            }
            if($word->meaning2 != null){
                $vocword = $vocword . ', ' . $word->meaning2;
            }
            if($word->meaning3 != null){
                $vocword = $vocword . ', ' . $word->meaning3;
            }
             if($word->meaning4 != null){
                $vocword = $vocword . ', ' . $word->meaning4;
            }

            if($word->parentheses != null){
                $vocword = $vocword . ' (' . $word->parentheses . ' )';
            }

            array_push($voc[$index], $vocword);


        }//end of foreach $word

        // dd($phrases);
        // dd($questions);
        // dd($voc);
        // dd($phrase_supports);

        if($layout == "classic"){
            $page_to_render = 'TextClassic';
        }
        if($layout == "cola"){
            $page_to_render = 'TextCola';
        }

        return Inertia::render($page_to_render, [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'title' => $title[0]->text_title,
        'phrases' => $phrases,
        'questions' => $questions,
        'phrase_supports' => $phrase_supports,
        'voc' => $voc
        ]);

    }

    public function showNormal($id){
        $id = $id;

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

        $voc = array();
        
        foreach($text_words as $word) {
        
            $vocword = "";
            if($word->memorize == 1){
                $vocword = "* " . $vocword;
            }
            $vocword = $vocword . $word->word;
            if($word->wordinfo1 != null && !str_starts_with($word->wordinfo1, '+')){
                $vocword = $vocword . ',' . $word->wordinfo1;
            }
            elseif($word->wordinfo1 != null){
                $vocword = $vocword . $word->wordinfo1;
            }
            if($word->wordinfo2 != null){
                $vocword = $vocword . ', ' . $word->wordinfo2;
            }
            if($word->wordinfo3 != null){
                $vocword = $vocword . ', ' . $word->wordinfo3;
            }
             if($word->wordinfo4 != null){
                $vocword = $vocword . ', ' . $word->wordinfo4;
            }
            
            $vocword = $vocword . ': ';

            if($word->meaning1 != null){
                $vocword = $vocword . $word->meaning1;
            }
            if($word->meaning2 != null){
                $vocword = $vocword . ', ' . $word->meaning2;
            }
            if($word->meaning3 != null){
                $vocword = $vocword . ', ' . $word->meaning3;
            }
             if($word->meaning4 != null){
                $vocword = $vocword . ', ' . $word->meaning4;
            }

            if($word->parentheses != null){
                $vocword = $vocword . ' (' . $word->parentheses . ' )';
            }

            array_push($voc, $vocword);


        }//end of foreach $word

        // dd($phrases);
        // dd($questions);
        // dd($voc);
        // dd($phrase_supports);

        $page_to_render = 'TextNormal';

        return Inertia::render($page_to_render, [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'title' => $title[0]->text_title,
        'text_words' => $text_words,
        'voc' => $voc
        ]);

    }

}
