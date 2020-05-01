<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use App\Models\UsersModel;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;
use Throwable;

/**
 * Class LeaderboardController
 * @package App\Http\Controllers
 */
class LeaderboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Leaderboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Creating Players for the application
    |
    */

    use AuthenticatesUsers;

    /** @var UsersModel $usersModel */
    private $usersModel;

    /**
     * LeaderboardController constructor.
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
        /* Retrieve all users from DB */
        $users = DB::table('users')->get();

        return view('leaderboard', [
            'users' => $users
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function postAction(Request $request)
    {


        return response()
            ->json([
                'status' => 'Leaderboard',
                'payload' => [
                    'player-a' => 'Player A name & score',
                    'player-b' => 'Player B name & score',
                    'player-c' => 'Player C name & score',
                    'player-d' => 'Player D name & score',
                    'player-e' => 'Player E name & score',
                    'player-f' => 'Player F name & score',
                    'player-g' => 'Player G name & score',
                ]
            ]);
    }
}

