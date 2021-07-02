<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $title;
    public $subtitle;
    public $items;

    public function __construct($title, $subtitle, $items)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->items = $items;
    }

    public function render()
    {
        return view('admin.components.breadcrumb');
    }
}
