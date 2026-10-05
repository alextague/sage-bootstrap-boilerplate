<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedImage extends Component
{
    /**
     * Get the featured image data
     *
     * @param  $id  $id [Post ID]
     * @param  $size  $size [Image Size]
     * @return $image_url
     * @return $srcset
     * @return $image_alt
     * @return $image_title
     * @return $image_width
     * @return $image_height
     */
    public $image_url;

    public $srcset;

    public $sizes;

    public $image_alt;

    public $image_title;

    public $image_width;

    public $image_height;

    protected $imageId;

    protected $size;

    public function __construct($imageId = null, $size = 'full', $srcsetSizes = null)
    {
        $thumbnailId = get_post_thumbnail_id($imageId);

        if ($thumbnailId) {
            $image = wp_get_attachment_image_src($thumbnailId, $size);
            $image_meta = get_post($thumbnailId);
            $image_alt = get_post_meta($thumbnailId, '_wp_attachment_image_alt', true);

            // Set image alt to the title if empty
            if (empty($image_alt)) {
                $image_alt = str_replace('-', ' ', $image_meta->post_title);
            }

            $this->image_url = $image[0];
            $this->image_width = $image[1];
            $this->image_height = $image[2];
            $this->srcset = wp_get_attachment_image_srcset($thumbnailId, $size);
            $this->image_alt = $image_alt;
            $this->image_title = $image_meta->post_title;

            // Only set sizes when srcset is available; omit otherwise
            if ($this->srcset) {
                $this->sizes = $srcsetSizes ?? '100vw';
            }
        } else {
            $this->image_url = 'https://picsum.photos/1920/1080';
            $this->srcset = '';
            $this->image_alt = 'placeholder';
            $this->image_title = 'placeholder';
            $this->image_width = '1920';
            $this->image_height = '1080';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.responsive-image');
    }
}
