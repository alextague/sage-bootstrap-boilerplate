<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageBuilder extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-builder',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'page_builder' => $this->pageBuilder(),
        ];
    }

    //------------------------------------------------//
    //---------------- ACF PAGE BUILDER --------------//
    //------------------------------------------------//

    protected function pageBuilder()
    {
        if (have_rows('page_builder')) {

            $page_builder = get_field('page_builder');

            $data = [];

            foreach ($page_builder as $module) {

                $params = [];
                foreach ($module as $key => $param) {
                    $params['uid'] = uniqid();
                    $params[$key] = $param;
                }
                $this_module = (object) $params;

                array_push($data, $this_module);
            }

            $data = (object) $data;

            return $data;

        }
    }
}
