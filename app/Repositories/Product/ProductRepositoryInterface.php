<?php

namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{

    /**
     * get images by product_id
     * @param $id
     * @return mixed
     */
    function getImages($id);
}
