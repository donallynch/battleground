<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    /** @var UsersModel $usersModel */
    private $usersModel;

    /**
     * Controller constructor.
     * @param Request $request
     * @param UsersModel $usersModel
     * @throws InvalidArgumentException
     */
    public function __construct(
        Request $request,
        UsersModel $usersModel
    ) {
        $this->usersModel = $usersModel;
    }
}

