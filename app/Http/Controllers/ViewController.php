<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;

class ViewController extends Controller
{
    public function xss(){
        $users = User::all();

        return view('xss', ["users" => $users]);
    }
}