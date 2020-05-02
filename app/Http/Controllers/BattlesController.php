<?php

namespace App\Http\Controllers;

use App\Services\BattleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class BattlesController
 * @package App\Http\Controllers
 */
class BattlesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Battles Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Battle management for the application
    |
    */

    /** @var BattleService $battleService */
    private $battleService;

    /**
     * BattlesController constructor.
     * @param BattleService $battleService
     * @param Request $request
     * @throws InvalidArgumentException
     */
    public function __construct(
        BattleService $battleService,
        Request $request
    ) {
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

