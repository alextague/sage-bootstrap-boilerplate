<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PostsByCat extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $posts_by_cat;

    protected $cat;
    protected $postsPerPage;

    public function __construct($cat, $postsPerPage = 4)
    {
        $this->posts_by_cat = $this->getPostsByCat($cat, $postsPerPage);
    }

    protected function getPostsByCat($cat, $postsPerPage)
    {
        return collect(get_posts([
            'post_type' => 'post',
            'category' => [$cat],
            'posts_per_page' => $postsPerPage,
        ]))->map(function ($post) {
            return (object) [
                'ID' => $post->ID,
            ];
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.posts-by-cat');
    }
}
