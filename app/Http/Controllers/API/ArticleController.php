<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                                  FrontEnd                                  */
    /* -------------------------------------------------------------------------- */




    /* -------------------------------------------------------------------------- */
    /*                                 Admin Panel                                */
    /* -------------------------------------------------------------------------- */

    public function main()
    {
        return view('admin.master.article');
    }
}
