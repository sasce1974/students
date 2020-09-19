<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function show($id){
        $board = Board::findOrFail($id);
        $users = $board->users;
        return view('board.index', compact('board', 'users'));
    }
}
