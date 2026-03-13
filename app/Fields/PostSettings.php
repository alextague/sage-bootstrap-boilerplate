<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class PostSettings extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $post_settings = Builder::make('post_settings');

        $post_settings
            ->setLocation('post_type', '==', 'post');

        $post_settings
            ->setGroupConfig('position', 'acf_after_title');

        $post_settings
            ->addText('featured_image_positioning')
            ->addText('first_image_positioning');

        return $post_settings->build();
    }
}
