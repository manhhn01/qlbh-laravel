<?php

namespace App\Repositories\Coupon;

use App\Repositories\RepositoryInterface;

interface CouponRepositoryInterface extends RepositoryInterface
{
    /**
     * find coupon by id or name
     * @param $id
     * @return mixed
     */
    function findByIdOrName($id);
}
