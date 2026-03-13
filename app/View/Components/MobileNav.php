<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MobileNav extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $menu_items;

    public function __construct($menuLocation = null)
    {
        $this->menu_items = $this->getMenuItems($menuLocation);
    }

    public function getMenuItems($menu_name = null) {
        $locations = get_nav_menu_locations();
        if ( isset( $locations[ $menu_name ] ) ) {
            $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
            $menu_items = wp_get_nav_menu_items($menu->term_id);
        } else {
            $menu_items = array();
        }

        $current_id = '';
        $menu_items_array = array();
        foreach ($menu_items as $item) {
            $current_id = $item->ID;
            $menu_item_parent = $item->menu_item_parent;
            if (!$item->menu_item_parent) {
                $menu_items_array[$current_id]['title'] = $item->title;
                $menu_items_array[$current_id]['url'] = $item->url;
                $menu_items_array[$current_id]['target'] = $item->target;
                $menu_items_array[$current_id]['object_id'] = $item->object_id;
                $menu_items_array[$current_id]['children'] = array();
            } else {
                $menu_items_array[$menu_item_parent]['children'][$current_id]['title'] = $item->title;
                $menu_items_array[$menu_item_parent]['children'][$current_id]['url'] = $item->url;
                $menu_items_array[$menu_item_parent]['children'][$current_id]['target'] = $item->target;
                $menu_items_array[$menu_item_parent]['children'][$current_id]['object_id'] = $item->object_id;
            }
        }
        return $menu_items_array;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.mobile-nav');
    }
}
