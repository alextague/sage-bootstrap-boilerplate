<?php

namespace App\View\Components;

use App\BootstrapNav;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavMenu extends Component
{
    /**
     * Nav Menu slug
     *
     * @var string
     */
    public $nav_menu;

    public function __construct($menuLocation = null)
    {
        $this->nav_menu = wp_nav_menu(
            ['theme_location' => $menuLocation,
                'container' => '',
                'container_class' => '',
                'menu_class' => 'navbar-nav',
                'depth' => 2,
                'walker' => new BootstrapNav]
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-menu');
    }
}
