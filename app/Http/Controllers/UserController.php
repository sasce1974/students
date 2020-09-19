<?php

namespace App\Http\Controllers;

use App\Board;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Board $board, Request $request)
    {

        $request->validate([
            'name'=>'required|max:200|string|unique:users'
        ]);

        $board->users()->create(['name'=>$request->name]);

        return redirect('/board/' . $board->id)->with('success', 'User created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Board $board, $id)
    {
        $user = $board->users->where('id', $id)->first(); // User::findOrFail($id);
        if(!$user) abort(404);
        return view('user.show', compact('board', 'user'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Board $board, $id)
    {
        $user = User::findOrFail($id);
        if($board->users()->where('id', $id)->first()){
            $user->delete();
            return redirect('/board/' . $board->id)->with('success', 'User deleted');
        }else{
            abort(404);
        }


    }
}
