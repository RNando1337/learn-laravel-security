<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use function Termwind\render;

class ViewController extends Controller
{
    public function xss()
    {
        /**
         * You can set this payload <script>alert(1)</script> maybe in name field on the users table then see on http://127.0.0.1:8000/xss-sample
         */

        $users = User::all();

        return view('xss', ["users" => $users]);
    }

    public function pathTraversal()
    {
        /**
         * You can try this payload to see the difference
         *
         * http://127.0.0.1:8000/path-traversal?view=.env
         * http://127.0.0.1:8000/path-traversal?download=.env
         * http://127.0.0.1:8000/path-traversal?view_patch=.env
         * http://127.0.0.1:8000/path-traversal?download_patch=.env
         * 
         */
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
        /**
         * You can try this payload to see the difference
         *
         * http://127.0.0.1:8000/redirect?location=https://www.google.com
         * http://127.0.0.1:8000/redirect?location_whitelist=https://example.com
         * http://127.0.0.1:8000/redirect?location_regex=https://example.com
         * 
         */
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
        /**
         * You can try this payload to see the difference
         *
         * http://127.0.0.1:8000/injection?domain=www.google.com;ls -a
         * http://127.0.0.1:8000/injection?injection_patch=www.google.com;ls -a
         * 
         */
        if(request('domain') != null){
            return system('whois '.request('domain'));
        }

        if(request('injection_patch') != null){
            return system('whois '.escapeshellcmd(request('injection_patch')));
        }
    }

    public function sqlInjection()
    {
        /**
         * You can try this payload to see the difference
         *
         * http://127.0.0.1:8000/sql-injection?email='1' OR email LIKE '%%'
         * http://127.0.0.1:8000/sql-injection?email_vuln='1' OR email LIKE '%%'
         * 
         */
        if(request('email_vuln') !== null){
            $user = DB::table('users')->whereRaw('email = '.request('email_vuln').'')->first();
            return $user;
        }

        //prevent code
        if(request('email')){
            $user = DB::table('users')->where('email', request('email'))->first();
            return $user;
        }
    }
}