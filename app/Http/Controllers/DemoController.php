<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    //
    public function hii(Request $request)
    {
        return ['msg'=>'BISMILLAH','msg2'=>'Allahu Akbar.'];
    }
}
