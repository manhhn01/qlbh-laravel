<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ListProducts extends Component
{
    /**
     * List products to show.
     *
     * @var []
     */
    public $products;

    /**
     * @var string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($products = null, $type = 'index')
    {
        $this->products = $products;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        switch ($this->type) {
            case 'note-add':
            case 'add':
                return view('components.list-products.add');
            case 'note-edit':
            case 'edit':
                return view('components.list-products.edit');
            default:
                return view('components.list-products.index');
        }
    }
}
