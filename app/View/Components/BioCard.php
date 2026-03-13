<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BioCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $modal;
    public $first_name;
    public $last_name;
    public $bio_title;
    public $bio_company;
    public $featured_image;
    public $info;
    public $bio_id;

    public function __construct($modal = null, $bioId = null)
    {
        $this->modal = $modal;
        $this->first_name = get_field('first_name', $bioId);
        $this->last_name = get_field('last_name', $bioId);
        $this->featured_image = get_the_post_thumbnail_url($bioId, 'large');
        $this->info = json_encode($this->escaped_info(get_field('info', $bioId)));
        $this->bio_id = $bioId;
        $this->bio_title = get_field('title', $bioId);
        $this->bio_company = get_field('company', $bioId);
    }

    protected function escaped_info($info) {
        $info = str_replace('\'', '&#39;', $info);
        $info = str_replace('\"', '&#34;', $info);

        return $info;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bio-card');
    }
}
