<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    // Show the search results page
    public function search()
    {
        return View('search');
    }
}
