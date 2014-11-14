<?php
/**
 * Created by PhpStorm.
 * User: 08121_000
 * Date: 11/1/2014
 * Time: 5:31 PM
 */

/**
 * CEMS SubscribeForm Shortcode
 * [cems_subscribe id='13' theme='CEMSSubscribeForm13']
 *
 * @class              CEMSSubscribeFormShortcode
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-10-17
 * @version            1.0.0
 *
 */
class CEMSSubscribeFormShortcode extends WPDKShortcode {

    /**
     * Create or return a singleton instance of CEMSEvent17Shortcode
     *
     * @brief Create or return a singleton instance of CEMSEvent17Shortcode
     *
     * @return CEMSSubscribeFormShortcode
     */
    public static function getInstance()
    {
        $instance = null;
        if ( is_null( $instance ) ) {
            $instance = new CEMSSubscribeFormShortcode();
        }
        return $instance;
    }

    /**
     * Alias of getInstance();
     *
     * @brief Init the shortcode register
     *
     * @return CEMSSubscribeFormShortcode
     */
    public static function init()
    {
        return self::getInstance();
    }

    /**
     * Return the array with the list of allowed shortcode
     *
     * @brief Preview Subscription Button shortcode
     *
     * @return array
     */
    function shortcodes	()
    {
        $shortcodes = array(
            'cems_subscribe' => true
        );
        return $shortcodes;
    }

    /**
     * Display the subscribe form with its full function
     *
     *     $defaults = array(
     *      'id' => -1
     *     );
     *
     * @brief Display the subscribe form
     *
     * @param array       $attributes    Attribute into the shortcode
     *
     * @return string
     */
    function cems_subscribe( $attributes ) {
        $output = '';
        $defaults = array(
            'id' => -1,
            'theme' => 'CEMSSubscribeForm13',
            'quiz' => ''
        );

        $attributes = shortcode_atts( $defaults, $attributes, 'cems_subscribe' );
        //TODO: create form depend on attribute: theme
        $class = ucwords($attributes['theme']);
        if (class_exists($class)) {
            $formContent = new $class($attributes);
            $output = $formContent->html();
            return $output;
        }
        return '';
    }

}