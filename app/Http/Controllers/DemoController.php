<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    //

    public function demo()
    {
        return ["owner" => "julfikar", "msg" => "Subhanallah, Alhamdulillah, Allahu Akbar"];
    }
}
