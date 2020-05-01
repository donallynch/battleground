<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use App\Models\UsersModel;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;
use Throwable;

/**
 * Class CreatePlayerController
 * @package App\Http\Controllers
 */
class CreatePlayerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CreatePlayer Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Creating Players for the application
    |
    */

    use AuthenticatesUsers;

    /** @var UsersModel $usersModel */
    private $usersModel;

    /**
     * CreatePlayerController constructor.
     * @param UsersModel $usersModel
     * @param LoginModel $loginModel
     * @param Request $request
     * @throws InvalidArgumentException
     */
    public function __construct(
        UsersModel $usersModel,
        LoginModel $loginModel,
        Request $request
    ) {
        parent::__construct($request, $usersModel);
        $this->loginModel = $loginModel;
    }

    /**
     * @return Factory|View
     */
    public function indexAction()
    {
        return view('create-player');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function postAction(Request $request)
    {
        /* Create player (db insert) */
        // ...

        return response()
            ->json([
                'status' => 'Player created',
                'payload' => [
                    'name' => 'supplied name'
                ]
            ]);
    }
}

