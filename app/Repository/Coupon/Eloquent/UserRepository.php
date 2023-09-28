<?php

namespace App\Repository\Coupon\Eloquent;

use App\Models\User;
use App\Repository\Coupon\Interfaces\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
