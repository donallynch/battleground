<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitBattlePost;
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

        /* Secure route */
        $session = $request->session()->get('user');
        if ($session === null) {
            $this->show404();
        }
    }

    /**
     * @return Factory|View
     */
    public function indexAction()
    {
        /* Retrieve all incomplete Battles from DB */
        $users = DB::table('users')
            ->get();

        $usersData = [];
        foreach ($users as $user) {
            $usersData[$user->id] = $user->name;
        }

        return view('submit-battle', [
            'players' => $usersData
        ]);
    }

    /**
     * @param Request $request
     * @param SubmitBattlePost $submitBattlePost
     * @return JsonResponse
     */
    public function postAction(Request $request, SubmitBattlePost $submitBattlePost)
    {
        $player1 = $request->get('player-1');
        $player2 = $request->get('player-2');

        /* Submit battle (db insert) */
        /* Mark battle as complete */
        DB::table('battles')
            ->insert([
                'user_a'  => $player1,
                'user_b'  => $player2
            ]);

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

