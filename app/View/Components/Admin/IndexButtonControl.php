<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class IndexButtonControl extends Component
{
    public $url;
    public $title;

    public function __construct($url = "", $title = "")
    {
        $this->url = $url;
        $this->title = $title;
    }

    public function render()
    {
        return view('admin.components.index.button-control');
    }
}
