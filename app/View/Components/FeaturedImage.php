<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FeaturedImage extends Component
{
    /**
     * Get the featured image data
     *
     * @param $id $id [Post ID]
     * @param $size $size [Image Size]
     *
     * @return $image_url
     * @return $srcset
     * @return $image_alt
     * @return $image_title
     * @return $image_width
     * @return $image_height
     */

    public $image_url;
    public $srcset;
    public $image_alt;
    public $image_title;
    public $image_width;
    public $image_height;

    protected $imageId;
    protected $size;
    protected $srcsetSizes;

    public function __construct($imageId = null, $size = "full")
    {
        if (get_post_thumbnail_id($imageId)) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($imageId), $size);
            $image_meta = get_post(get_post_thumbnail_id($imageId));
            $image_alt = get_post_meta(get_post_thumbnail_id($imageId), '_wp_attachment_image_alt', true);

            // Set image alt to the title if empty
            if (empty($image_alt)) {
                $image_alt = str_replace('-', ' ', $image_meta->post_title);
            }

            $srcset = wp_get_attachment_image_srcset( get_post_thumbnail_id($imageId), $size );

            $this->image_url = $image[0];
            $this->image_width = $image[1];
            $this->image_height = $image[2];
            $this->srcset = wp_get_attachment_image_srcset( get_post_thumbnail_id($imageId), $size );
            $this->sizes = $srcsetSizes;
            $this->image_alt = $image_alt;
            $this->image_title = $image_meta->post_title;
        } else {
            $this->image_url = "https://picsum.photos/1920/1080";
            $this->srcset = "";
            $this->image_alt = "placeholder";
            $this->image_title = "placeholder";
            $this->image_width = "1920";
            $this->image_height = "1080";
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
