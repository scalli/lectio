<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
        ->select('*')
        ->get();

        // dd($users);

        return Inertia::render('Users', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $text_info_id = DB::table('users')->insertGetId([
            'name' => $request->username,
            'email'  => $request->email,
            'password'  => Hash::make($request->password),
            'current_team_id'  => 2
        ]);

        return $this->index();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->password != "") {
            $affected = DB::table('users')
            ->where('id', $request->id)
            ->update(['name' => $request->username,
                      'email' => $request->email,
                      'password' => Hash::make($request->password)            
         ]);
        }
        else { //Password not changed
            $affected = DB::table('users')
            ->where('id', $request->id)
            ->update(['name' => $request->username,
                      'email' => $request->email            
         ]);
        }


        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
