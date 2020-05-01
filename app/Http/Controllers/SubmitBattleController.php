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
 * Class SubmitBattleController
 * @package App\Http\Controllers
 */
class SubmitBattleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SubmitBattle Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Creating Players for the application
    |
    */

    use AuthenticatesUsers;

    /** @var UsersModel $usersModel */
    private $usersModel;

    /**
     * SubmitBattleController constructor.
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
        return view('submit-battle');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function postAction(Request $request)
    {
        /* Submit battle (db insert) */
        // ...

        return response()
            ->json([
                'status' => 'Battle scheduled',
                'payload' => [
                    'player-a' => 'Player A name',
                    'player-b' => 'Player B name'
                ]
            ]);
    }
}

