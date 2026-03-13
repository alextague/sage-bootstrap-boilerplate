<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RecentPosts extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $recent_posts;

    protected $postsPerPage;

    public function __construct($postsPerPage = 4)
    {
        $this->recent_posts = $this->getRecentPosts($postsPerPage);
    }

    protected function getRecentPosts($postsPerPage)
    {
        return collect(get_posts([
            'post_type' => 'post',
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
        return view('components.recent-posts');
    }
}
