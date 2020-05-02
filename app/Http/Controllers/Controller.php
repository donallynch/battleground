<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    /**
     * Exit application with 404 page
     */
    public function show404()
    {
        abort(404);
    }
}

