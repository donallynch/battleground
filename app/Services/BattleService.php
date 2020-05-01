<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

/**
 * Class BattleService
 * @package App\Services
 */
class BattleService
{
    /** @var bool $battleComplete */
    private $battleComplete = false;

    /**
     * Fight Simulator
     * @param $battle
     * @return array
     */
    public function fightSimulator($battle)
    {
        /* Randomly select number of turns/attacks per battle */
        $maxTurns = 100;
        $i = 1;
        $battleLog = [];

        /* Simulate a battle */
        while ($i <= $maxTurns) {

            /* Retrieve both Users involved in the battle */
            $userA = DB::table('users')->find($battle->user_a);
            $userB = DB::table('users')->find($battle->user_b);

            if ($this->battleComplete) {
                break;
            }

            /* Let User A attack User B */
            $battleLog[] = $this->attack($userA, $userB, $i);

            if ($this->battleComplete) {
                break;
            }

            /* Let User B attack User A */
            $battleLog[] = $this->attack($userB, $userA, $i);

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
     * Attack Process
     *  Call this twice swapping the Users for the second call
     * @param $userA
     * @param $userB
     * @return array
     */
    public function attack($userA, $userB, $entryCount)
    {
        $status = 'Played';
        $code = 1;

        /* Is Opponent lucky */
        $lucky = (int)$userB->luck_value;
        $newLuckValue = rand(0, 1);

        $healthDeduction = 0;
        $attackStrength = (($userA->attack_value / 2));
        $opponentNewHealth = $userB->hit_points - $attackStrength;
        $opponentNewStrength = $userB->attack_value - floor($attackStrength / 10);
        $opponentGold = $userB->gold;

        /* 10% of Opponents Gold (if Opponent is NOT lucky) */
        $winnings = floor($userB->gold / 100) * 10;

        /* Ensure Opponent has health */
        if ($opponentNewHealth < 0) {
            /* Kill the player (set hit_points to 0) */
            if ($userB->hit_points > 0) {
                $opponentNewHealth = 0;
            } else {
                $opponentNewHealth = 0;
                $this->battleComplete = true;
                $status = "{$userB->name} doesn&apos;t have enough health to play! GAME OVER!";
                $code = 2;
            }
        }

        /* Ensure Players have enough strength to play */
        if ($userA->hit_points === 0) {
            $opponentNewStrength = 0;
            $this->battleComplete = true;
            $status = "{$userA->name} doesn&apos;t have enough strength to play! GAME OVER!";
            $code = 3;
        }

        /* Ensure Opponent has strength */
        if ($opponentNewStrength < 0) {
            $opponentNewStrength = 0;
            $this->battleComplete = true;
            $status = "{$userB->name} doesn&apos;t have enough strength to play! GAME OVER!";
            $code = 3;
        }

        /**
         * Ensure Opponent has gold
         *  Can only assume that GOLD is the currency of the application without which you can't battle!
         *  Not sure if it's accumulated like loot crates or if you buy it like in a casino etc...
         */
        if ($opponentGold <= 0 || $userB->gold === 0) {
            $opponentGold = 0;
            $this->battleComplete = true;
            $status = "{$userB->name} doesn&apos;t have enough gold to play! GAME OVER";
            $code = 4;
        }

        /* Prepare the battlelog */
        $battleLog = [
            'entryCount' => $entryCount,
            'player1' => $userA->name,
            'player2' => $userB->name,
            'status' => $status,
        ];

        /* If Battle in progress */
        if ($code === 1) {
            /* Update Users */
            DB::table('users')
                ->where('id', $userA->id)
                ->update([
                    'gold'          => $userA->gold + $winnings,
                    'luck_value'    => $newLuckValue
                ]);
            DB::table('users')
                ->where('id', $userB->id)
                ->update([
                    'attack_value'  => $opponentNewStrength,
                    'hit_points'    => $opponentNewHealth,
                    'gold'          => $userB->gold - $winnings,
                    'luck_value'    => $newLuckValue
                ]);

            $battleLog = array_merge($battleLog, [
                'entryCount' => $entryCount,
                'player1' => $userA->name,
                'player2' => $userB->name,
                'isPlayerBLucky' => ($newLuckValue) ? 'Yes' : 'No',
                'hitPoints' => $attackStrength,
                'healthDeduction' => $healthDeduction,
                'attackStrength' => $attackStrength,
                'opponentNewStrength' => $opponentNewStrength,
                'winnings' => $winnings,
                'status' => $status,
            ]);
        }

        return $battleLog;
    }

    /**
     * Getter for BattleComplete
     * @return bool
     */
    public function getBattleComplete()
    {
        return $this->battleComplete;
    }
}

