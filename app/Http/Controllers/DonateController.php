<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonateController extends Controller
{
    public function show(){
        return view('donate.donate'); 
    }

    public function generate(Request $request){
        $amount = $request->input('amount');
        $qrUrl = "https://img.vietqr.io/image/VCB-9889641156-compact2.png?amount={$amount}&addInfo=Donate%20cho%20DTUEnglishHub&accountName=Website%20DTUEnglishHub";

        return view('donate.donate', compact('amount', 'qrUrl'));
    }
}


