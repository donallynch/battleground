<?php

namespace App\Models;

use App\Repos\PhotoRepo;
use App\Repos\Pivot__users__photo__primaryRepo;
use App\Repos\PivotRoleUserRepo;
use App\Repos\RolesRepo;
use App\Repos\User;
use App\Entities\Responder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Psr\SimpleCache\InvalidArgumentException;

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

    /** @var array $duplicatePhotoSizes */
    private $duplicatePhotoSizes = null;

    /** @var array $sessionProfilePhotoKey */
    private $sessionProfilePhotoKey = null;

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

    /**
     * @param Request $request
     * @return Collection|mixed
     * @throws InvalidArgumentException
     */
    public function retrieveProfileUser(Request $request)
    {
        /* Retrieve Profile ID */
        $profileId = $request->session()->get('p_user',  0);

        if ($profileId === 0) {
            if (session()->has('user')) {
                $profileId = session()->get('user')['id'];
            } else {
                return new Collection();
            }
        }

        /* Retrieve User Entity */
        $userEntity = $this->getUser([
            'id' => $profileId
        ]);

        return $userEntity;
    }

    /**
     * @param Request $request
     * @return array|string|null
     * @throws InvalidArgumentException
     */
    public function getName(Request $request)
    {
        /* Retrieve Profile User */
        $profileOwner = $this->retrieveProfileUser($request);

        /* Retrieve Profile User */
        $sessionOwner = $this->getUser();

        $self = $profileOwner[0]->id === $sessionOwner[0]->id;

        /**
         * Determine if SessionOwner is viewing their own profile
         */
        if ($self) {
            return __('messages.your');
        }

        /**
         * Viewing someone else's profile
         */
        return "{$profileOwner[0]->first_name}&apos;s";
    }
}

