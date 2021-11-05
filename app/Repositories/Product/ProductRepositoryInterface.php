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

    /**
     * find product by id or sku
     * @param $id_sku
     * @return mixed
     */
    function findByIdOrSku($id_sku);
}
