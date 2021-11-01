<?php

namespace App\Repositories\Supplier;

use App\Repositories\RepositoryInterface;

interface SupplierRepositoryInterface extends RepositoryInterface
{
    /**
     * return products paginate
     * @param $amount
     * @param $supplier_id
     * @param null $filter
     * @return mixed
     */
    function getProductsPage($amount, $supplier_id, $filter);
}
