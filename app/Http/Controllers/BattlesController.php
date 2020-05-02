<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use App\Models\UsersModel;
use App\Http\Controllers\Controller;
use App\Services\BattleService;
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

    /** @var BattleService $battleService */
    private $battleService;

    /** @var UsersModel $usersModel */
    private $usersModel;

    /**
     * BattlesController constructor.
     * @param UsersModel $usersModel
     * @param LoginModel $loginModel
     * @param BattleService $battleService
     * @param Request $request
     * @throws InvalidArgumentException
     */
    public function __construct(
        UsersModel $usersModel,
        LoginModel $loginModel,
        BattleService $battleService,
        Request $request
    ) {
        parent::__construct($request, $usersModel);
        $this->loginModel = $loginModel;
        $this->battleService = $battleService;

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
        $battles = DB::table('battles')->where([
            'is_complete' => 0
        ])->get();

        $battleLog = [];
        foreach ($battles as $battle) {
            /* Simulate battle */
            $this->battleService->setBattleComplete(false);
            $battleLog = array_merge($battleLog, $this->battleService->fightSimulator($battle));
        }

        return view('battles', [
            'battleLog' => $battleLog
        ]);
    }
}

