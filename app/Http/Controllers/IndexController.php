<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use App\Models\UsersModel;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;
use Throwable;

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
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen.
    |
    */

    use AuthenticatesUsers;

    /** @var UsersModel $usersModel */
    private $usersModel;

    /** @var LoginModel $loginModel */
    private $loginModel;

    /**
     * IndexController constructor.
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
     * Handle an authentication attempt.
     *
     * @param Request $request
     * @return bool
     */
    public function authenticate(Request $request)
    {
        return true;
    }

    /**
     * @return Factory|View
     */
    public function indexAction()
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function postAction(Request $request)
    {
        /* Perform login in Model */
        $response = $this->loginModel->login($request);

        /* Ensure Model was successful */
        if ($response->getStatus() !== 200) {
            return response()->json($response->getArray());
        }

        /* Laravel authenticate User */
        $this->authenticate($request);

        /* Retrieve UserEntity from Model response */
        $userId = $response->getPayload()['user-id'];

        /* Put User into session (User ID ONLY) */
        if (!$request->session()->has('user')) {
            session([
                'user' => [
                    'id' => $userId
                ]
            ]);
        }

        return response()
            ->json([
                'status' => $response->getStatus(),
                'code' => $response->getCode(),
                'payload' => [
                    'username' => $response->getPayload()['username']
                ]
            ])
            ->cookie('c_user', $userId, 31536000);
    }
}

