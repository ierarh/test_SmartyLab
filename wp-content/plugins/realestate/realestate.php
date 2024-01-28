<?php
/**
 * Plugin Name: Real Estate
 * Description: Test work
 * Version: 0.0.1
 * Author: Kyrylo Samojlenko
 * License: GPL3
 */

define('RE_ROOT', dirname(__FILE__));
define('RE_URL', plugin_dir_url(__FILE__));

require_once RE_ROOT . '/src/Autoload.php';
new \RealEstate\Autoload('RealEstate', RE_ROOT . '/src');

class RealEstate
{
    use \RealEstate\Objects\Singleton;

    const TEXTDOMAIN = 'realestate';

    protected function __construct()
    {
        \RealEstate\Components\Registered::instance();
        \RealEstate\Components\Short_Code::instance();
        new \RealEstate\Components\Widget();
    }
}

if (class_exists('RealEstate')) {
    RealEstate::instance();
}