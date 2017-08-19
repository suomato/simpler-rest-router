<?php

/*
Plugin Name: Simpler Rest Router
Plugin URI:  https://github.com/suomato/simpler-rest-route
Description: This plugin helps you to make WordPress REST endpoints in a simpler way.
Version:     0.1.0
Author:      Toni Suomalainen
Author URI:  https://github.com/suomato/simpler-rest-route
License:     MIT
License URI: https://opensource.org/licenses/MIT
*/

namespace Suomato;

defined('ABSPATH') or die('Not allowed');

if ( ! class_exists('Suomato\Router')) {
    class Router
    {
        public static function register($route)
        {
            add_action('rest_api_init', function () use ($route) {

                $route['base'] = str_replace('{', '(?P<', $route['base']);
                $route['base'] = str_replace('}', '>\w+)', $route['base']);

                register_rest_route($route['namespace'] . '/', $route['base'], [
                    'methods'             => $route['methods'],
                    'callback'            => $route['callback'],
                    'permission_callback' => $route['permission_callback'] ?? null,
                    'args'                => $route['params'] ?? [],
                ]);
            });
        }
    }
}
