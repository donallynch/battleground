<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

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
    | This controller handles displaying the Leaderboard
    |
    */

    /**
     * LeaderboardController constructor.
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
        /* Retrieve all users from DB */
        $users = DB::table('users')
            ->orderBy('gold', 'DESC')
            ->get();

        return view('leaderboard', [
            'users' => $users
        ]);
    }
}

