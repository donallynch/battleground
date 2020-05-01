<?php

namespace App\Repos;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class User
 * @package App\Repos
 */
class User extends Authenticatable
{
    use Notifiable;

    /** @var array $fillable */
    protected $fillable = ['id','name','gold','attack_value','hit_points','luck_value'];

    /** @var array $hidden */
    protected $hidden = [];

    /** @var string $table */
    protected $table = 'users';

    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $dateFormat */
    protected $dateFormat = 'U';

    /** @var string $connection */
    protected $connection = 'mysql';

    /**
     * User constructor.
     */
    public function __construct() {
        parent::__construct([]);
    }

    /**
     * @param array $where
     * @param array $params
     * @return bool
     */
    public function updateInstance(array $where, array $params)
    {
        /* Update entity in database */
        $this->where($where)->update($params);

        return true;
    }

    /**
     * @param array $params

     * @return bool|Collection|mixed
     * @throws InvalidArgumentException
     */
    public function create(array $params)
    {
        return true;
    }
}

