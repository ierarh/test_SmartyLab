<?php

namespace RealEstate\Components;

use RealEstate\Objects\Singleton;

class Short_Code
{
    use Singleton;

    protected $name = 're_shortcode';

    protected function __construct()
    {
        add_shortcode($this->name, [$this, 'shortcode']);

    }

    public function shortcode()
    {
        if (class_exists('ACF')) {
            if (!is_admin()) {
                ob_start();
                require RE_ROOT . '/views/shortcode.php';
                return ob_get_clean();
            }
        }

        return;
    }

}