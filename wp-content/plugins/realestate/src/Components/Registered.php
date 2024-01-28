<?php

namespace RealEstate\Components;

use RealEstate\Objects\Singleton;
use RealEstate;

class Registered
{
    use Singleton;

    public static $post_type_id = 'realestate';
    public static $post_type_slug = 'realestate';

    public static $taxonomy_id = 'district';
    public static $taxonomy_slug = 'district';

    protected function __construct()
    {
        add_action('init', [$this, 'register']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets'], 100);
    }

    public function register()
    {
        $this->post_type();
        $this->taxonomy();
        $this->acf_fieldset();

        Rest::instance();
    }

    public function register_assets()
    {
        wp_enqueue_style('_re-styles', RE_URL . 'assets/css/styles.css', [], 1.0);
        wp_enqueue_script('_re-app', RE_URL . 'assets/js/app.js', ['jquery'], 1.0, true);
    }

    protected function post_type()
    {
        $args = [
            'labels' => [
                'name' => __('Real Estates', RealEstate::TEXTDOMAIN),
                'singular_name' => __('Real Estate', RealEstate::TEXTDOMAIN),
                'menu_name' => __('Real Estate', RealEstate::TEXTDOMAIN),
                'add_new' => __('Add New Estate', RealEstate::TEXTDOMAIN),
            ],
            'hierarchical' => false,
            'public' => true,
            'publicly_queryable' => true,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 15,
            'menu_icon' => 'dashicons-admin-multisite',
            'supports' => [
                'title'
            ],
            'rewrite' => [
                'slug' => $this::$post_type_slug,
                'with_front' => true
            ],
            'show_in_rest' => false,
            'taxonomies' => [
                $this::$taxonomy_id
            ]
        ];

        register_post_type($this::$post_type_id, $args);

        flush_rewrite_rules();
    }

    protected function taxonomy()
    {
        $labels = [
            'name' => __('Districts', RealEstate::TEXTDOMAIN),
            'singular_name' => __('District', RealEstate::TEXTDOMAIN),
        ];

        $args = [
            'labels' => $labels,
            'hierarchical' => false,
            'public' => false,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'query_var' => true,
            'rewrite' => [
                'slug' => $this::$taxonomy_slug,
                'with_front' => false,
                'hierarchical' => false,
            ],
        ];

        register_taxonomy($this::$taxonomy_id, [$this::$post_type_id], $args);

    }

    protected function acf_fieldset()
    {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group([
                'key' => $this::$post_type_id . '_fields',
                'title' => 'Estate Fields',
                'fields' => [
                    [
                        'key' => 'estate_name',
                        'label' => __('Building Name', RealEstate::TEXTDOMAIN),
                        'name' => 'estate_name',
                        'type' => 'text',
                        'required' => true,
                        'wrapper' => [
                            'width' => '25%'
                        ]
                    ],
                    [
                        'key' => 'estate_coordinate',
                        'label' => __('Coordinate', RealEstate::TEXTDOMAIN),
                        'name' => 'estate_coordinate',
                        'type' => 'text',
                        'required' => true,
                        'wrapper' => [
                            'width' => '35%'
                        ]
                    ],
                    [
                        'key' => 'estate_floor',
                        'label' => __('Floor count', RealEstate::TEXTDOMAIN),
                        'name' => 'estate_floor',
                        'type' => 'select',
                        'required' => true,
                        'wrapper' => [
                            'width' => '20%'
                        ],
                        'choices' => range(1, 20),
                        'ui' => true,
                        'return_format' => 'label',
                    ],
                    [
                        'key' => 'estate_type',
                        'label' => __('Type of building', RealEstate::TEXTDOMAIN),
                        'name' => 'estate_type',
                        'type' => 'radio',
                        'required' => true,
                        'wrapper' => [
                            'width' => '20%'
                        ],
                        'choices' => [
                            'panel' => __('Panel', RealEstate::TEXTDOMAIN),
                            'bricks' => __('Bricks', RealEstate::TEXTDOMAIN),
                            'blocks' => __('Foam Block', RealEstate::TEXTDOMAIN),
                        ],
                        'return_format' => 'value',
                    ]
                ],
                'location' => [
                    [
                        [
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => $this::$post_type_id,
                        ]
                    ]
                ]
            ]);
        }
    }
}