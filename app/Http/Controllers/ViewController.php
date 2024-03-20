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

        // prevent code
        if(request('view_patch') != null){
            $file = basename(base_path('/').request('view_patch'));

            if (file_exists($file)) {
                return file_get_contents($file);
            } else {
                echo "File not found!";
            }
        }

        if(request('download_patch') != null){
            $file = basename(base_path('/').request('download_patch'));

            return response()->download($file);
        }
    }

    public function redirect()
    {
        if(request('location') != null){
            return redirect(request('location'));
        }

        //prevent code

        // with whitelist method
        $accepted_site = ["https://www.google.com", url(''), '/home'];
        if(request('location_whitelist') != null && in_array(request('location_whitelist'), $accepted_site)){
            return redirect(request('location_whitelist'));
        }

        // with regex
        $regex_pattern = '/[a-zA-Z]*?.?(?:google|facebook|youtube)(?:.)[a-zA-Z]+/';
        if(preg_match($regex_pattern, request('location_regex')))
        {
            return redirect(request('location_regex'));
        }
    }

    public function injection()
    {
        if(request('domain') != null){
            return system('whois '.request('domain'));
        }

        if(request('injection_patch') != null){
            return system('whois '.escapeshellcmd(request('injection_patch')));
        }
    }
}