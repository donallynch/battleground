<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Logging into the application
    |
    */

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
    public function postAction(
        Request $request,
        LoginPost $loginPost
    ) {
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

        /* Put User into session */
        session(['user' => $userObject]);

        return new JsonResponse([
            'status' => __('messages.login-success', ['name' => $user[0]->name]),
            'user' => $userObject
        ], 200);
    }
}

