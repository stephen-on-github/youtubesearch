<?php

namespace App\Http\Controllers;

use App\Youtube;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @param $request  Request   filters from the server (keyword, type)
     *
     * @return string JSON list of search results and details about the search
     */
    public function search(Request $request)
    {
        $youtube = new Youtube();
        $results = $youtube->search($request);

        return response()->json($results);
    }
}
