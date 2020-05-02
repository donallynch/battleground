<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitBattlePost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

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
    | This controller handles Submitting Battles into the application
    |
    */

    /**
     * SubmitBattleController constructor.
     * @param Request $request
     * @throws InvalidArgumentException
     */
    public function __construct(Request $request) {
        /* Secure route */
        $session = $request->session()->get('user');
        if ($session === null) {
            $this->show404();
        }
    }

    /**
     * @return View
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
    public function postAction(
        Request $request,
        SubmitBattlePost $submitBattlePost
    ) {
        $player1 = $request->get('player-1');
        $player2 = $request->get('player-2');

        /* Submit battle (db insert) */
        DB::table('battles')
            ->insert([
                'user_a'  => $player1,
                'user_b'  => $player2
            ]);

        return response()
            ->json([
                'status' => 'Battle scheduled',
                'payload' => [
                    'player-a' => $player1,
                    'player-b' => $player2
                ]
            ]);
    }
}

