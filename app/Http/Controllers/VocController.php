<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use \stdClass;

use Illuminate\Http\Request;
use Inertia\Inertia;

use File;
use Illuminate\Support\Facades\Response;
// use Illuminate\Http\Response;
use Storage;
use ZipArchive;

use App\Models\Voc as Voc;
use Redirect;

class VocController extends Controller
{
    public function show($layout, $id){

        $id = $id;
        $layout = $layout;

        $text_words = DB::table('texts')
            ->join('vocs', 'texts.word_voc', '=', 'vocs.id')
            ->select('*')
            ->where('text_info_id', '=', $id)
 //           ->groupBy('vocs.id') //to select distinct words --> trouble with phrases
            ->get();

        $title = DB::table('text_infos')
            ->select('text_title')
            ->where('id', '=', $id)
            ->get();

        // dd($title[0]->text_title);
        // dd(($text_words[count($text_words)-1])->phrase_number);

        // $max_index = ($text_words[count($text_words)-1])->phrase_number;
        // $phrases = array_fill(1, $max_index, "");//array containing all phrases
        // $voc_front = array();
        // $voc_back = array();
        // $voc = array();
        
        // foreach($text_words as $word) {
        //     $index = $word->phrase_number;
        //     $phrases[$index] = $phrases[$index] . " " . $word->text_word;
        // }

        // foreach($text_words as $word) {
        //     // $index = $word->phrase_number;
        //     // $phrases[$index] = $phrases[$index] . " " . $word->text_word;
        
        //     $vocword_back = "";
        //     if($word->memorize == 1){
        //         $o = new stdClass();
        //         $o->word = $word->word;
        //         $o->id = $word->id;
        //         $o->phrase_number = $word->phrase_number;
        //         //TODO
        //         $o->phrase = "";
        //         if($o->phrase_number>1){
        //             $o->phrase = $o->phrase . $phrases[$o->phrase_number-1];
        //         }
        //         $o->phrase = $o->phrase . $phrases[$o->phrase_number];
        //         if($o->phrase_number != count($phrases)){
        //             $o->phrase = $o->phrase . $phrases[$o->phrase_number+1];
        //         }
        //         // array_push($voc_front, $o );

        //         if($word->wordinfo1 != null && str_starts_with($word->wordinfo1, '+')){
        //             $o->word = $o->word . ' + ';
        //         }
        //         if($word->wordinfo1 != null && !str_starts_with($word->wordinfo1, '+')){
        //             $vocword_back = $vocword_back . $word->wordinfo1;
        //             $o->word = $o->word . ', ';
        //         }
        //         elseif($word->wordinfo1 != null){
        //             $vocword_back = $vocword_back . $word->wordinfo1;
        //         }
        //         if($word->wordinfo2 != null){
        //             $vocword_back = $vocword_back . ', ' . $word->wordinfo2;
        //         }
        //         if($word->wordinfo3 != null){
        //             $vocword_back = $vocword_back . ', ' . $word->wordinfo3;
        //         }
        //          if($word->wordinfo4 != null){
        //             $vocword_back = $vocword_back . ', ' . $word->wordinfo4;
        //         }
                
        //         $vocword_back = $vocword_back . ': ';

        //         if($word->meaning1 != null){
        //             $vocword_back = $vocword_back . $word->meaning1;
        //         }
        //         if($word->meaning2 != null){
        //             $vocword_back = $vocword_back . ', ' . $word->meaning2;
        //         }
        //         if($word->meaning3 != null){
        //             $vocword_back = $vocword_back . ', ' . $word->meaning3;
        //         }
        //          if($word->meaning4 != null){
        //             $vocword_back = $vocword_back . ', ' . $word->meaning4;
        //         }

        //         if($word->parentheses != null){
        //             $vocword_back = $vocword_back . ' (' . $word->parentheses . ' )';
        //         }

        //         $o->back = $vocword_back;
        //         $o->attempts = 0;
        //         $o->corrects = 0;
        //         $o->box = 1;

        //         //Add the complete word to check different meanings and stamtijden when profound excercise
        //         if($layout == "profound"){
        //             $o->word_complete = $word;
        //         }
        //         // array_push($voc_back, $vocword_back);
        //         if(!$this->isInVocAlready($voc,$o->id)){
        //             array_push($voc, $o );
        //         }
        //     }//end of if memorize

        // }//end of foreach $word

        // dd($voc_front);
        // dd($voc_back);
        //This method replaces everything in comment above
        $voc = $this->makeVocCards($text_words, $layout);

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
        // 'phrases' => $phrases,
        'voc' => $voc
        // 'voc_front' => $voc_front,
        // 'voc_back' => $voc_back
        ]);
    }

    private function isInVocAlready(array $myArray, $id) {
        foreach ($myArray as $element) {
            if ($element->id == $id) {
                    return true;
                }
        }
        return false;
    }

    public function repetitioStep1(){
        
        $text_infos = DB::table('text_infos')
        ->select('*')
        ->get();

         $systematisches = DB::table('systematisches')
        ->select('*')
        ->get();

        return Inertia::render('Repetitio1', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'text_infos' => $text_infos,
        'systematisches' => $systematisches,
        ]);
    }

    public function repetitioStep2(Request $request){
        // dd($request->systematisches);
        // dd($request->textinfos);

        $query = "select * from texts join vocs on texts.word_voc = vocs.id where ((";

        for($i=0;$i<count($request->systematisches);$i++){
            $query = $query . 'vocs.part_of_speech = ' . $request->systematisches[$i]['id'];
            if($i<count(($request->systematisches))-1){
                $query = $query . ' OR ';
            }
        }
        $query = $query . ") AND (";

        for($i=0;$i<count($request->textinfos);$i++){
            $query = $query . 'texts.text_info_id = ' . $request->textinfos[$i]['id'];
            if($i<count(($request->textinfos))-1){
                $query = $query . ' OR ';
            }
        }

        $query = $query . ") AND vocs.memorize = 1) GROUP BY vocs.id";
        
        // dd($query);

        $text_words = DB::select($query);
        // dd($text_words);

        $layout = $request->layout;
        // dd($layout);

        $voc = $this->makeVocCards($text_words, $layout);

        if($layout == "quick"){
            $page_to_render = 'VocQuick';
        }
        if($layout == "profound"){
            $page_to_render = 'VocProfound';
        }

        return Inertia::render($page_to_render, [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'title' => "Voc. oefenen van " . count($request->textinfos) . " teksten",
        // 'phrases' => $phrases,
        'voc' => $voc
        // 'voc_front' => $voc_front,
        // 'voc_back' => $voc_back
        ]);


    }

    public function export(Request $request){
        // dd($request->systematisches);
        // dd($request->textinfos);

        $query = "select * from texts join vocs on texts.word_voc = vocs.id where ((";

        for($i=0;$i<count($request->systematisches);$i++){
            $query = $query . 'vocs.part_of_speech = ' . $request->systematisches[$i]['id'];
            if($i<count(($request->systematisches))-1){
                $query = $query . ' OR ';
            }
        }
        $query = $query . ") AND (";

        for($i=0;$i<count($request->textinfos);$i++){
            $query = $query . 'texts.text_info_id = ' . $request->textinfos[$i]['id'];
            if($i<count(($request->textinfos))-1){
                $query = $query . ' OR ';
            }
        }

        $query = $query . ")) GROUP BY vocs.id"; //AND vocs.memorize = 1
        
        // dd($query);

        $text_words = DB::select($query);
        // dd($text_words);

       $layout = "profound";

        $voc_to_memorize = $this->makeVocCardsForExport($text_words,1,0);
        $voc_not_to_memorize =  $this->makeVocCardsForExport($text_words,0,1);
        $voc_complete =  $this->makeVocCardsForExport($text_words,1,1);
        // dd($voc);


        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        
        $section = $phpWord->addSection();
        $section->addText('Filter gebruikt voor deze woordsoorten:', array('color' => '#0000FF', 'size' => '16', 'bold' => "true"));
        $systematisches = $request->systematisches;
        $categoriesFilter = "";
        for($i=0;$i<count($systematisches);$i++){
            $categoriesFilter = $categoriesFilter . ($systematisches[$i]['part_of_speech']) . " - ";
        }
        $section->addText($categoriesFilter);
        
        $text_infos = $request->textinfos;
        $section = $phpWord->addSection();
        $section->addText('Filter gebruikt voor deze teksten:', array('color' => '#0000FF', 'size' => '16', 'bold' => "true"));
        $textFilter = "";
        for($i=0;$i<count($text_infos);$i++){
            $textFilter = $textFilter . ($text_infos[$i]['text_title']) . " - ";
        }
        $section->addText($textFilter);
        
        $section->addPageBreak();

        $section = $phpWord->addSection();
        // $text = $section->addText("text test");
        $section->addText('Te kennen vocabularium:', array('color' => '#0000FF', 'size' => '16', 'bold' => "true"));
        $table = $section->addTable();
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        for($i=0;$i<count($voc_to_memorize);$i++){
            $table->addRow();
            $table->addCell()->addText($voc_to_memorize[$i]->word)->setFontStyle($fontStyle);;
            $table->addCell()->addText($voc_to_memorize[$i]->wordinfo)->setFontStyle($fontStyle);;
            $table->addCell()->addText($voc_to_memorize[$i]->wordmeaning)->setFontStyle($fontStyle);;
            // $text = $section->addText($text_words[$i]->word);
        }
        $section = $phpWord->addSection();
        $section->addText('Niet te kennen vocabularium:', array('color' => '#0000FF', 'size' => '16', 'bold' => "true"));
        // $text = $section->addText("text test");
        $table = $section->addTable();
        for($i=0;$i<count($voc_not_to_memorize);$i++){
            $table->addRow();
            $table->addCell()->addText($voc_not_to_memorize[$i]->word);
            $table->addCell()->addText($voc_not_to_memorize[$i]->wordinfo);
            $table->addCell()->addText($voc_not_to_memorize[$i]->wordmeaning);
            // $text = $section->addText($text_words[$i]->word);
        }
        $section = $phpWord->addSection();
        $section->addText('Alle vocabularium:', array('color' => '#0000FF', 'size' => '16', 'bold' => "true"));
        // $text = $section->addText("text test");
        $table = $section->addTable();
        for($i=0;$i<count($voc_complete);$i++){
            $table->addRow();
            if($voc_complete[$i]->memorize == 1){
                $table->addCell()->addText($voc_complete[$i]->word)->setFontStyle($fontStyle);;
                $table->addCell()->addText($voc_complete[$i]->wordinfo)->setFontStyle($fontStyle);;
                $table->addCell()->addText($voc_complete[$i]->wordmeaning)->setFontStyle($fontStyle);;
            }
            else{
                $table->addCell()->addText($voc_complete[$i]->word);
                $table->addCell()->addText($voc_complete[$i]->wordinfo);
                $table->addCell()->addText($voc_complete[$i]->wordmeaning);
            }

            // $text = $section->addText($text_words[$i]->word);
        }

        usort($voc_to_memorize, array($this, "comparePartOfSpeech"));
        $section = $phpWord->addSection();
        $section->addText('Te kennen vocabularium per woordsoort:', array('color' => '#0000FF', 'size' => '16', 'bold' => "true"));
        $table = $section->addTable();
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        for($i=0;$i<count($voc_to_memorize);$i++){
            if(($i>0) && ($voc_to_memorize[$i]->part_of_speech != $voc_to_memorize[$i-1]->part_of_speech)){
                $section = $phpWord->addSection();
                $section->addText($voc_to_memorize[$i]->part_of_speech);
                $table = $section->addTable();
            }
            
            $table->addRow();
            $table->addCell()->addText($voc_to_memorize[$i]->word)->setFontStyle($fontStyle);;
            $table->addCell()->addText($voc_to_memorize[$i]->wordinfo)->setFontStyle($fontStyle);;
            $table->addCell()->addText($voc_to_memorize[$i]->wordmeaning)->setFontStyle($fontStyle);;


            // $text = $section->addText($text_words[$i]->word);
        }


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $docxName = time() . 'voc';

        $this->removeStoredDocx();

        $objWriter->save(storage_path('app/') . 'public/' . $docxName . '.docx');
        // $url  = url('');
        // $documentlink = $url . '/voc/downloadvoc/' . time() . 'voc';
    	
 
        // Storage::put('file1.txt', 'Your name');

        // $asset = asset('storage/1654893063voc.docx');
        $asset = asset('storage/' . $docxName . '.docx');

        return Inertia::render('ExportVoc', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        // 'docxName' => $docxName,
        'asset' => $asset
        // 'title' => "Voc. oefenen van " . count($request->textinfos) . " teksten",
        // 'phrases' => $phrases,
        // 'voc' => $voc
        // 'voc_front' => $voc_front,
        // 'voc_back' => $voc_back
        ]);


    }

    function removeStoredDocx(){
        // dd((storage_path('app\public')));
        $files = Storage::files('\public');
        // dd($files);
        Storage::delete($files);
    }

    function makeVocCards($text_words, $layout){
        // $max_index = ($text_words[count($text_words)-1])->phrase_number;
        // $phrases = array_fill(1, $max_index, "");//array containing all phrases
        $voc_front = array();
        $voc_back = array();
        $voc = array();
        

        // foreach($text_words as $word) {
        //     $index = $word->phrase_number;
        //     $phrases[$index] = $phrases[$index] . " " . $word->text_word;
        // }

        // dd($phrases);

        foreach($text_words as $word) {
            // $index = $word->phrase_number;
            // $phrases[$index] = $phrases[$index] . " " . $word->text_word;
        
            $vocword_back = "";
            if($word->memorize == 1){
                $o = new stdClass();
                $o->word = $word->word;
                $o->id = $word->id;
                // $o->phrase_number = $word->phrase_number;
                //TODO
                // $o->phrase = "";
                // if($o->phrase_number>1){
                //     $o->phrase = $phrases[$o->phrase_number-1] . $o->phrase;
                // }
                // $o->phrase = $o->phrase . $phrases[$o->phrase_number];
                // if($o->phrase_number != count($phrases)){
                //     $o->phrase = $o->phrase . $phrases[$o->phrase_number+1];
                // }
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
                $o->box = 1;

                //Add the complete word to check different meanings and stamtijden when profound excercise
                if($layout == "profound"){
                    $o->word_complete = $word;
                }
                // array_push($voc_back, $vocword_back);
                if(!$this->isInVocAlready($voc,$o->id)){
                    array_push($voc, $o );
                }
            }//end of if memorize

        }//end of foreach $word

        return $voc;

        // dd($voc_front);
        // dd($voc_back);
    }

    function compareTextWords($a, $b) {
        if($a->text_info_id !== $b->text_info_id){
            return $a->text_info_id > $b->text_info_id;
        }
        else{
            return $a->position > $b->position;
        }
        // dd(($a->position < $b->position)?-1:1);
        // dd($a);
        // return ($a->position < $b->position)?-1:1;
    }

    function comparePartOfSpeech($a, $b) {

            return $a->part_of_speech > $b->part_of_speech;

        // dd(($a->position < $b->position)?-1:1);
        // dd($a);
        // return ($a->position < $b->position)?-1:1;
    }

    function makeVocCardsForExport($text_words, $voc_to_memorize, $voc_not_to_memorize){
        $max_index = ($text_words[count($text_words)-1])->phrase_number;
        // dd($text_words);
        // $phrases = array_fill(1, $max_index, "");//array containing all phrases
        $voc_front = array();
        $voc_back = array();
        $voc = array();


        foreach($text_words as $word) {

            if(($voc_to_memorize && $word->memorize == 1)|| ($voc_not_to_memorize && $word->memorize != 1)){
                $o = new stdClass();
                $o->word = $word->word;
                $o->id = $word->id;
                $o->position = $word->position;
                $o->text_info_id = $word->text_info_id;
                $o->part_of_speech = $word->part_of_speech;
                $o->memorize = $word->memorize;


                // if($word->wordinfo1 != null && str_starts_with($word->wordinfo1, '+')){
                //     $o->word = $o->word . ' + ';
                // }
                // if($word->wordinfo1 != null && !str_starts_with($word->wordinfo1, '+')){
                //     $vocword_info = $vocword_info . $word->wordinfo1;
                //     $o->word = $o->word . ', ';
                // }
                // elseif($word->wordinfo1 != null){
                $vocword_info = "";
                    if($word->wordinfo1 != null){
                    $vocword_info = $vocword_info . $word->wordinfo1;
                }
                if($word->wordinfo2 != null){
                    $vocword_info = $vocword_info . ', ' . $word->wordinfo2;
                }
                if($word->wordinfo3 != null){
                    $vocword_info = $vocword_info . ', ' . $word->wordinfo3;
                }
                 if($word->wordinfo4 != null){
                    $vocword_info = $vocword_info . ', ' . $word->wordinfo4;
                }

                $o->wordinfo = $vocword_info;
                
                $vocword_meaning = "";

                if($word->meaning1 != null){
                    $vocword_meaning = $vocword_meaning . $word->meaning1;
                }
                if($word->meaning2 != null){
                    $vocword_meaning = $vocword_meaning . ', ' . $word->meaning2;
                }
                if($word->meaning3 != null){
                    $vocword_meaning = $vocword_meaning . ', ' . $word->meaning3;
                }
                 if($word->meaning4 != null){
                    $vocword_meaning = $vocword_meaning . ', ' . $word->meaning4;
                }

                if($word->parentheses != null){
                    $vocword_meaning = $vocword_meaning . ' (' . $word->parentheses . ' )';
                }

                $o->wordmeaning = $vocword_meaning;

                if(!$this->isInVocAlready($voc,$o->id)){
                    array_push($voc, $o );
                }
            }//end of if memorize

        }//end of foreach $word

        //  usort($voc, fn($a, $b) => ($a["position"] < $b["position"])?-1:1);
        usort($voc, array($this, "compareTextWords"));

        return $voc;

        // dd($voc_front);
        // dd($voc_back);
    }


    public function store(Request $request)
    {

        // dd($request);
        $validated = $request->validate([
            'groundword' => 'required',
            'meaning1' => 'required',
            'part_of_speech' => 'required',
        ]);

        $voc = new Voc;
        $voc->word = $request->groundword;
        $voc->memorize = $request->memorize;
        $voc->wordinfo1 = $request->wordinfo1;
        $voc->wordinfo2 = $request->wordinfo2;
        $voc->wordinfo3 = $request->wordinfo3;
        $voc->wordinfo4 = $request->wordinfo4;
        $voc->meaning1 = $request->meaning1;
        $voc->meaning2 = $request->meaning2;
        $voc->meaning3 = $request->meaning3;
        $voc->meaning4 = $request->meaning4;
        $voc->part_of_speech = $request->part_of_speech;
        //TODO: Get id of logged in user
        $voc->contributor = 1;
        $voc->parentheses = $request->parentheses;

        $voc->save();


        return redirect()->action([TextController::class, 'new']);
        // return Redirect::route($request->redirect_url);
    }

    //Not needed anymore because of direct link to asset in storage
    public function downloadvoc(Request $request)
    {
        // $filepath = $filepath;
        // dd($request->docxName);
 
        // $file = Storage::disk('public')->get($request->docxName.'.docx');
        // $file = Storage::get('1654893063voc.docx');

        // $file = Storage::get('file.txt');
        // $url = Storage::url('file.txt');
        // dd($url);
        // return Storage::download('public/file1.txt');
        // echo asset('storage/file1.txt');
        
        //WERKT!! Maakt url naar het asset
        asset('storage/1654893063voc.docx');
        // return response()->download(asset('storage/1654893063voc.docx'));
        // return response()->download(("colosseum.jpg"));

        // return Storage::download('1654893063voc.docx', "vocabularium", [
        //         'Content-Type' => ' application/pdf',
        //         'Content-Description' => 'File Transfer',
        //         'Content-Disposition' => 'attachment;  filename='.$request->docxName.'.docx',
        //         'Content-Transfer-Encoding' => 'binary'
        //     ]);
  
        // return (new Response($file, 200))->header('Content-Type', 'application/msword');

        // dd($docxName);

        // $filepath = public_path('1654893993voc'.'.docx');
        // dd($filepath);
        // return Response::download($filepath); 

        // OK
        // return response()->download(public_path($request->docxName.'.docx', "vocabularium"));

        //------------------------------ ZIP TRIAL --------------------------------------
        // $zip = new ZipArchive;
   
        // $fileName = 'voc.zip';
   
        // if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        // {
   			
        //     $file = public_path($request->docxName.'.docx');
        //     $relativeNameInZipFile = basename($file);
        //     $zip->addFile($relativeNameInZipFile);
             
        //     $zip->close();
        // }
        // // Download the generated zip
        // return response()->download(($fileName));
        // return response()->download($fileName, "vocabularium", [
        //     'Content-Type' => ' application/zip',
        //     'Content-Description' => 'File Transfer',
        //     'Content-Disposition' => "attachment;  filename=\"". $fileName."\"",
        //     'Content-Transfer-Encoding' => 'binary'
        // ]);
        //------------------ END OF ZIP TRIAL --------------------------------------------

        // return Storage::download('1654893063voc.docx');

        // return response()->download($request->docxName.'.docx', "vocabularium", [
        //     'Content-Type' => ' application/zip',
        //     'Content-Description' => 'File Transfer',
        //     'Content-Disposition' => 'attachment;  filename='.$request->docxName.'.docx',
        //     'Content-Transfer-Encoding' => 'binary'
        // ]);
        
        // return response()->download(public_path('1654893993voc'.'.docx'));

    }
}
