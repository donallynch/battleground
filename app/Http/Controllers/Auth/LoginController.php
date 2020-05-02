<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginPost;
use App\Models\LoginModel;
use App\Models\UsersModel;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen.
    |
    */

    /** @var UsersModel $usersModel */
    private $usersModel;

    /** @var LoginModel $loginModel */
    private $loginModel;

    /**
     * LoginController constructor.
     * @param UsersModel $usersModel
     * @param LoginModel $loginModel
     * @param Request $request
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
        return view('login');
    }

    /**
     * Very Basic Auth System
     *  TODO:: Replace with email & password verification
     * @param Request $request
     * @param LoginPost $loginPost
     * @return JsonResponse
     */
    public function postAction(Request $request, LoginPost $loginPost)
    {
        /* Get vars from request */
        $name = $request->post('name');

        /* Retrieve User entity (by name) */
        $user = DB::table('users')
            ->where('name', '=', $name)
            ->get();

        /* Ensure User exists */
        if (!count($user->toArray())) {
            return new JsonResponse([
                'status' => __('messages.login-failed'),
                'errors' => ['name' => 'User not found']
            ], 400);
        }

        $userObject = [
            'id' => $user[0]->id,
            'name' => $user[0]->name
        ];

        /* Put User into session (User ID ONLY) */
        session(['user' => $userObject]);

        return new JsonResponse([
            'status' => __('messages.login-success', ['name' => $user[0]->name]),
            'user' => $userObject
        ], 200);
    }
}

