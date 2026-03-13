<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AcfImage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $image_url;
    public $srcset;
    public $maxWidth;
    public $image_width;
    public $image_height;
    public $image_alt;
    public $image_title;

    protected $imageId;
    protected $size;

    public function __construct($imageId = null, $size = "full", $maxWidth = "100%")
    {
        if (!empty($imageId)) {
            $image_src = wp_get_attachment_image_src( $imageId, $size );
            $image_meta = get_post(get_post_thumbnail_id($imageId));

            $this->image_url = $image_src[0];
            $this->image_width = $image_src[1];
            $this->image_height = $image_src[2];
            $this->srcset = wp_get_attachment_image_srcset( $imageId, $size );
            $this->image_alt = get_post_meta($imageId, '_wp_attachment_image_alt', TRUE);
            $this->image_title = $image_meta->post_title;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.responsive-image');
    }
}
