<?php

namespace App\Http\Controllers\NewFront;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewFrontController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(NFE.'.pages.index');
    }
}
