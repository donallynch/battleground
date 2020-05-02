<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles displaying the application homepage
    |
    */

    /**
     * @return View
     */
    public function indexAction()
    {
        return view('index');
    }
}

