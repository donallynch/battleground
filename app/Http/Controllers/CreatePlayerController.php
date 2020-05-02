<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class CreatePlayerController
 * @package App\Http\Controllers
 */
class CreatePlayerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CreatePlayer Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Creating Players for the application
    |
    */

    /**
     * CreatePlayerController constructor.
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
     * @return Factory|View
     */
    public function indexAction()
    {
        return view('create-player');
    }

    /**
     * Create Player
     * @param Request $request
     * @param CreatePlayerPost $createPlayerRequest
     * @return JsonResponse
     */
    public function postAction(
        Request $request,
        CreatePlayerPost $createPlayerRequest
    ) {
        /* Retrieve params from request */
        $name = $request->get('name');
        $gold = $request->get('gold');
        $strength = $request->get('strength');
        $health = $request->get('health');
        $luck = $request->get('luck');

        $playerData = [
            'name' => $name,
            'gold' => $gold,
            'attack_value' => $strength,
            'hit_points' => $health,
            'luck_value' => $luck
        ];

        /* Create player (db insert) */
        DB::table('users')->insert($playerData);

        return response()
            ->json([
                'status' => 'Player created',
                'payload' => $playerData
            ]);
    }
}

