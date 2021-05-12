<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginateController extends Controller
{
    public function __invoke($data)
    {
        return view('elements.paginate', ['data' => $data]);
    }
}
