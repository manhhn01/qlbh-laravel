<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrderProducts extends Component
{
    /**
     * List products to show
     *
     * @var $products[]
     */
    public $products;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render()
    {
        return view('components.order-products');
    }
}
