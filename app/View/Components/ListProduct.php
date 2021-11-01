<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ListProduct extends Component
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
     * @return View
     */
    public function render()
    {
        return view('components.list-product');
    }
}
