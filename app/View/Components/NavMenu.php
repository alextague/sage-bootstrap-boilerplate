<?php

namespace App\View\Components;

use App\BootstrapNav;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Walker_Nav_Menu;

class NavMenu extends Component
{
    /**
     * Rendered nav menu HTML, or null when no menu is assigned to the location.
     *
     * @var string|null
     */
    public $nav_menu;

    /**
     * Optional CSS class for a wrapping <nav> element.
     *
     * @var string|null
     */
    public $navClass;

    /**
     * Optional aria-label for a wrapping <nav> element.
     *
     * @var string|null
     */
    public $ariaLabel;

    public function __construct(
        $menuLocation = null,
        $menuClass = 'navbar-nav',
        $depth = 2,
        $useWalker = true,
        $walkerClass = null,
        $navClass = null,
        $ariaLabel = null
    ) {
        $this->navClass = $navClass;
        $this->ariaLabel = $ariaLabel;

        $args = [
            'theme_location' => $menuLocation,
            'container' => '',
            'container_class' => '',
            'menu_class' => $menuClass,
            'depth' => $depth,
            'echo' => false,
        ];

        if ($useWalker) {
            $walker = $walkerClass ?? BootstrapNav::class;

            // Fall back to the default walker rather than fatally erroring on a bad class name
            if (! class_exists($walker) || ! is_a($walker, Walker_Nav_Menu::class, true)) {
                $walker = BootstrapNav::class;
            }

            $args['walker'] = new $walker;
        }

        $this->nav_menu = has_nav_menu($menuLocation) ? wp_nav_menu($args) : null;
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
