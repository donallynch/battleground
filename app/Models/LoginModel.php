<?php

namespace App\Models;

use App\Entities\Responder;
use App\Repos\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Throwable;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class LoginModel
 *  This class is responsible for logging Users into the system
 * @package App\Models
 */
class LoginModel
{
    /** @var User $usersRepo */
    private $usersRepo;

    /** @var UsersModel $usersModel */
    private $usersModel;

    /**
     * LoginModel constructor.
     * @param User $usersRepo
     * @param UsersModel $usersModel
     * @param Responder $responder
     * @param Agent $agent
     */
    public function __construct(
        User $usersRepo,
        UsersModel $usersModel,
        Responder $responder,
        Agent $agent
    ){
        $this->usersRepo = $usersRepo;
        $this->usersModel = $usersModel;
        $this->responder = $responder;
        $this->agent = $agent;
    }

    /**
     * @param Request $request
     * @return Responder|bool
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function login(Request $request)
    {
        /* Get vars from request */
        $name = $request->post('name');

        /**
         * Retrieve User entity (by name)
         */
        $user = DB::table('users')->where('name', '=', $name)->get();
        
        echo'<pre>';
        var_dump($user);
        echo'</pre>';
        die('DIED AFTER CODE DEBUG');

        /* Ensure supplied password matches the bcrypted password in database */

        return $this->responder->set(200, __('messages.login.ok'), [], [
            'user-id' => $userEntity[0]->id,
            'name' => $userEntity[0]->name,
        ]);
    }
}

