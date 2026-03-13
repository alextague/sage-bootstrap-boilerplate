<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HeaderLogo extends Component
{
    /**
     * Logo ID
     *
     * @var string
     */
    public $logo;

    public function __construct()
    {
        $this->logo = get_field('header_logo', 'option');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-logo');
    }
}
