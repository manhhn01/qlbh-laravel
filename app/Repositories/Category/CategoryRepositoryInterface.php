<?php

namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * return products paginate
     * @param $amount
     * @param $category_id
     * @param null $filter
     * @return mixed
     */
    function getProductsPage($amount, $category_id, $filter);
}
