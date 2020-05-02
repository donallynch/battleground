<?php

namespace App\Models;

use App\Repos\User;
use App\Entities\Responder;

/**
 * Class UsersModel
 *  This class is responsible for Updating Users in the system
 *
 * @package App\Models
 */
class UsersModel
{
    /** @var User $usersRepo */
    private $usersRepo;

    /** @var Responder $responder */
    private $responder;

    /**
     * UsersModel constructor.
     * @param User $usersRepo
     * @param Responder $responder
     */
    public function __construct(
        User $usersRepo,
        Responder $responder
    ){
        $this->usersRepo = $usersRepo;
        $this->responder = $responder;
    }
}

