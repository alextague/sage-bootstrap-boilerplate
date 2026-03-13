<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PrimaryCategory extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $primary_category;

    protected $postID;

    public function __construct($postID = null)
    {
        $this->primary_category = $this->getPrimaryCategory($postID);
    }

    protected function getPrimaryCategory($postID)
    {
        $category = get_the_category($postID);

        if ($category) {
            if (class_exists('\WPSEO_Primary_Term')) {
                $wpseo_primary_term = new \WPSEO_Primary_Term('category', $postID);
                $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
                $term = get_term($wpseo_primary_term);
                if (is_wp_error($term)) {
                    return (object) $category[0];
                } else {
                    return (object) $term;
                }
            } else {
                return (object) $category[0];
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.primary-category');
    }
}
