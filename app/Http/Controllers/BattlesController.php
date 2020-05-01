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
 * Class BattlesController
 * @package App\Http\Controllers
 */
class BattlesController extends Controller
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
     * BattlesController constructor.
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
        /* Retrieve all incomplete Battles from DB */
        $battles = DB::table('battles')->where([
            'is_complete' => 0
        ])->get();

        $battleLog = [];
        foreach ($battles as $battle) {
            /* Simulate battle */
            $battleLog[] = $this->fightSimulator($battle);
        }

        return view('battles', [
            'battleLog' => $battleLog
        ]);
    }

    /**
     * @param $battle
     * @return array
     */
    private function fightSimulator($battle)
    {
        /* Randomly select number of turns/attacks per battle */
        $turns = 1;
        $i = 0;
        $battleLog = [];

        /* Retrieve both Users involved in the battle */
        $userA = DB::table('users')->find($battle->user_a);
        $userB = DB::table('users')->find($battle->user_b);

        /* Simulate a battle */
        while ($i < $turns) {
            $battleLog[] = $this->attack($userA, $userB);
            $battleLog[] = $this->attack($userB, $userA);
            $i++;
        }

        /* Mark battle as complete */
        DB::table('battles')
            ->where('id', $battle->id)
            ->update([
                'is_complete'  => 1
            ]);

        return $battleLog;
    }

    /**
     * @param $userA
     * @param $userB
     * @return array
     */
    private function attack($userA, $userB)
    {
        /* Is Opponent lucky */
        $lucky = $userB->luck_value;

        /* Calculate User A's attack value (if Opponent is NOT lucky) */
        $attackValue = (!$lucky) ? ($userA->attack_value / 2) * $userA->hit_points : 0;

        /* Reduce Opponent AttackStrength by 10% */
        $reducedAttackStrength = ceil(($userB->attack_value / 100) * 1);

        /* 10% of Opponents Gold (if Opponent is NOT lucky) */
        $winnings = (!$lucky) ? ($userB->gold / 100) * 10 : 0;

        /* New luck value */
        $newLuckValue = rand(0, 1);

        /* TODO:: Ensure Loser has gold to give */
        // ...

        /* Update both Users */
        DB::table('users')
            ->where('id', $userA->id)
            ->update([
                'gold'          => $userA->gold + $winnings,
                'luck_value'    => $newLuckValue
            ]);
        DB::table('users')
            ->where('id', $userB->id)
            ->update([
                'attack_value'  => $reducedAttackStrength,
                'gold'          => $userB->gold - $winnings
            ]);

        $battleLog = [
            'player1' => $userA->name,
            'player2' => $userB->name,
            'isPlayerBLucky' => ($lucky) ? 'Yes' : 'No',
            'attackValue' => $attackValue,
            'reducedAttackStrength' => $reducedAttackStrength,
            'winnings' => $winnings
        ];

        return $battleLog;
    }
}

