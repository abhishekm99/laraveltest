<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $title="WElcome to Laravel!";
        return view('pages.index')->with('title', $title);
    }

    public function about()
    {
        $title="ABOUT US!";
        return view('pages.about')->with('title', $title);
    }
}
