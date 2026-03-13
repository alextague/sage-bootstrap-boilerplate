<?php

namespace App\View\Components;

use Illuminate\View\Component;

class YoastSocialSharing extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $share_text;
    public $share_to;

    protected $postId;
    protected $shareText;
    protected $shareToArray;

    public function __construct($postId = null, $shareText, $shareToArray)
    {
        $this->share_to = [];
        $this->share_text = $shareText;

        foreach($shareToArray as $item) {
            if ($item == "facebook") {
                $this->share_to[$item]["href"] = "https://www.facebook.com/sharer/sharer.php?u=".get_the_permalink($postId);
                $this->share_to[$item]["fa_icon"] = "fa-facebook-f";
            }
            elseif($item == "twitter") {
                $this->share_to[$item]["href"] = "https://twitter.com/intent/tweet?text=".$this->yoastMeta($postId)['twitter_title']."&url=".get_the_permalink($postId);
                $this->share_to[$item]["fa_icon"] = "fa-twitter";
            }
            elseif($item == "linkedin") {
                $this->share_to[$item]["href"] = "https://www.linkedin.com/shareArticle?mini=true&url=". get_the_permalink($postId)."&title=".$this->yoastMeta($postId)['twitter_title']."&summary=".$this->yoastMeta($postId)['twitter_description'];
                $this->share_to[$item]["fa_icon"] = "fa-linkedin-in";
            }
        }
    }

    public static function yoastMeta($postId)
    {
        $data = [];
        $meta = get_post_meta($postId);

        if ($meta) {
            // This function also gets Facebook meta
            // Facebook scrapes the data on their own so no need to return it

            // Twitter
            $twitter_meta_title = $meta['_yoast_wpseo_twitter-title'][0] ?? '';
            $twitter_meta_description = $meta['_yoast_wpseo_twitter-description'][0] ?? '';
            $twitter_meta_image = $meta['_yoast_wpseo_twitter-image'][0] ?? '';

            $data['twitter_title'] = $twitter_meta_title;
            $data['twitter_description'] = $twitter_meta_description;
            $data['twitter_image'] = $twitter_meta_image;
        }

        return $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.yoast-social-sharing');
    }
}
