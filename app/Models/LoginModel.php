<?php

namespace App\Models;

use App\Entities\Responder;
use App\Repos\User;
use Illuminate\Http\Request;
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

    /** @var Responder $responder */
    private $responder;

    /** @var Agent $agent */
    private $agent;

    /** @var array $languages */
    protected $availableLanguages;

    /** @var string $sessionLocaleKey */
    protected $sessionLocaleKey;

    /** @var string $sessionAdvertProfileKey */
    protected $sessionAdvertProfileKey;

    const SUCCESSFUL_LOGIN = 1;
    const PREVENTED_LOGIN = 2;
    const USERNAME = 'username';
    const EMAIL = 'email';

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
        $password = $request->post('password');

        /**
         * Retrieve User entity (by email or username)
         */
        $userEntity = $this->usersModel->getUser([
            'name' => $name
        ]);

        /* Ensure supplied password matches the bcrypted password in database */
//        if (Hash::check($password, $userEntity[0]->password) === false) {
//            return $this->responder->set(400, __('messages.login.incorrect-password'), [
//                'password' => __('messages.login.incorrect-password')
//            ]);
//        }

        return $this->responder->set(200, __('messages.login.ok'), [], [
            'user-id' => $userEntity[0]->id,
            'name' => $userEntity[0]->name,
        ]);
    }
}

