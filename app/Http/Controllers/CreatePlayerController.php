<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerPost;
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

    use AuthenticatesUsers;

    /** @var UsersModel $usersModel */
    private $usersModel;

    /**
     * CreatePlayerController constructor.
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

