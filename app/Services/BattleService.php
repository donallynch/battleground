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

    const PLAYING = 1;
    const NOT_PLAYING = 2;

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
        $status = __('messages.played');
        $code = self::PLAYING;

        /* Is Opponent lucky */
        $lucky = $userB->luck_value;
        $newLuckValue = rand(0, 1);

        $attackStrength = ($lucky) ? 0 : (($userA->attack_value / 2));
        $healthDeduction = $attackStrength;
        $opponentInitialHealth = $userB->hit_points;
        $opponentNewHealth = $userB->hit_points - $attackStrength;
        $opponentInitialStrength = $userB->attack_value;
        $opponentNewStrength = $userB->attack_value - floor($attackStrength / 10);
        $opponentGold = $userB->gold;

        /* Between 10% and 20% of Opponents Gold (if Opponent is NOT unlucky) */
        $winnings = ($lucky) ? 0 : (floor($userB->gold / 100) * 10) + rand(0, 10);

        /* Ensure Opponent has health */
        if ($opponentNewHealth < 0) {
            /* Kill the player (set hit_points to 0) */
            if ($userB->hit_points > 0) {
                $opponentNewHealth = 0;
            } else {
                $opponentNewHealth = 0;
                $this->battleComplete = true;
                $status = __('messages.not-enough-health-to-play', ['name' => $userB->name]);
                $code = self::NOT_PLAYING;
            }
        }

        /* Ensure Players have enough strength to play */
        if ($userA->hit_points === 0) {
            $opponentNewStrength = 0;
            $this->battleComplete = true;
            $status = __('messages.not-enough-strength-to-play', ['name' => $userA->name]);
            $code = self::NOT_PLAYING;
        }

        /* Ensure Opponent has strength */
        if ($opponentNewStrength < 0) {
            $opponentNewStrength = 0;
            $this->battleComplete = true;
            $status = __('messages.not-enough-strength-to-play', ['name' => $userB->name]);
            $code = self::NOT_PLAYING;
        }

        /**
         * Ensure Opponent has gold
         *  Can only assume that GOLD is the currency of the application without which you can't battle!
         *  Not sure if it's accumulated like loot crates or if you buy it like in a casino etc...
         */
        if ($opponentGold <= 0 || $userB->gold === 0) {
            $opponentGold = 0;
            $this->battleComplete = true;
            $status = __('messages.not-enough-gold-to-play', ['name' => $userB->name]);
            $code = self::NOT_PLAYING;
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
                    'gold'          => $userA->gold + $winnings
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
                'isPlayerBLucky' => $lucky,
                'hitPoints' => $attackStrength,
                'opponentInitialHealth' => $opponentInitialHealth,
                'healthDeduction' => $healthDeduction,
                'attackStrength' => $attackStrength,
                'opponentInitialStrength' => $opponentInitialStrength,
                'opponentNewStrength' => $opponentNewStrength,
                'initialGold' => $opponentGold,
                'winnings' => $winnings,
                'status' => $status,
                'code' => $code
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

    /**
     * @param $battleComplete
     */
    public function setBattleComplete($battleComplete)
    {
        $this->battleComplete = $battleComplete;
    }
}

