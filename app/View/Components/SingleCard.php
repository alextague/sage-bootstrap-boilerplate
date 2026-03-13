<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SingleCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $featured_image;
    public $post_title;
    public $excerpt;
    public $link;
    public $post_id;

    public function __construct($postId = null)
    {
        $this->featured_image = get_the_post_thumbnail_url($postId, 'large');
        $this->post_title = get_the_title($postId);
        $this->excerpt = get_the_excerpt($postId);
        $this->link = get_the_permalink($postId);
        $this->post_id = $postId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.single-card');
    }
}
