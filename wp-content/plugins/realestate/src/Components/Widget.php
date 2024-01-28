<?php

namespace RealEstate\Components;

use RealEstate\Objects\Singleton;
use WP_Widget;

class Widget extends WP_Widget
{
    //use Singleton;

    public static $ID = 'realestate-wiget';
    public static $NAME = 'Real Estate';

    public function __construct() {
        parent::__construct(
            $this::$ID,
            __($this::$NAME, \RealEstate::TEXTDOMAIN)
        );
        add_action( 'widgets_init', function() {
            register_widget('\RealEstate\Components\Widget');
        });
    }

    public function widget( $args, $instance ) {

        if (class_exists('ACF')) {
            require RE_ROOT . '/views/widget.php';
        }
    }
}