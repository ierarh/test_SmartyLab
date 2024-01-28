<?php

namespace RealEstate\Components;

use RealEstate\Objects\Singleton;
use WP_REST_Request;
use WP_REST_Response;

class Rest
{
    use Singleton;

    public static $route = 'estates';

    protected function __construct()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    public function register()
    {
        register_rest_route(
            're/v2',
            $this::$route,
            [
                'methods' => 'POST',
                'callback' => [$this, 'callback']
            ]
        );
    }

    public function callback(WP_REST_Request $request)
    {
        global $wpdb;
        $params = $request->get_params();
        $name = isset($params['name']) ? $params['name'] : '';
        $floor = isset($params['floor']) ? $params['floor'] : '';
        $type = isset($params['type']) ? $params['type'] : '';
        $where = '';
        if (!empty($name)) {
            $where .= "AND pn.meta_value LIKE '%{$name}%' ";
        }

        if (!empty($floor)) {
            $floor -= 1;
            $where .= "AND pf.meta_value = {$floor} ";
        }

        if (!empty($type)) {
            $where .= "AND pt.meta_value='{$type}' ";
        }
        if ($results = $wpdb->get_results("SELECT p.ID, pn.meta_value as name, pf.meta_value as floor, 
            pt.meta_value as type, pc.meta_value as coordinate
            FROM {$wpdb->posts} p
            LEFT JOIN {$wpdb->postmeta} as pn ON pn.post_id=p.ID AND pn.meta_key='estate_name'
            LEFT JOIN {$wpdb->postmeta} as pf ON pf.post_id=p.ID AND pf.meta_key='estate_floor'
            LEFT JOIN {$wpdb->postmeta} as pt ON pt.post_id=p.ID AND pt.meta_key='estate_type'
            LEFT JOIN {$wpdb->postmeta} as pc ON pc.post_id=p.ID AND pc.meta_key='estate_coordinate'
            WHERE p.post_type ='" . Registered::$post_type_id . "' AND p.post_status = 'publish'
            {$where}
            LIMIT 10
            ")) {
            $results = array_chunk($results, 3);
            ob_start();

            require RE_ROOT . '/views/list.php';
            $list = ob_get_clean();
            return new WP_REST_Response($list);
        }
        return new WP_REST_Response(__('nothing found', \RealEstate::TEXTDOMAIN));
    }
}