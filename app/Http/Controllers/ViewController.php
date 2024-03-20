<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\User;
use Illuminate\Routing\Controller;

use function Termwind\render;

class ViewController extends Controller
{
    public function xss()
    {
        $users = User::all();

        return view('xss', ["users" => $users]);
    }

    public function pathTraversal()
    {
        if(request('view') != null){
            $file = base_path('/').request('view');

            if (file_exists($file)) {
                return file_get_contents($file);
            } else {
                echo "File not found!";
            }
        }

        if(request('download') != null){
            $file = base_path('/').request('download');

            return response()->download($file);
        }

        // Todo: make example for prevent code from path traversal attack
    }

    public function redirect()
    {
        if(request('location') != null){
            return redirect(request('location'));
        }

        // Todo: make example code for prevent from open redirect attack
    }
}