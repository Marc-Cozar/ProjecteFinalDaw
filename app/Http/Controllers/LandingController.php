<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function test() {
       
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // $output contains the output string
        $output = curl_exec($ch);

        dd($output);
        // close curl resource to free up system resources
        curl_close($ch);
    }
}
