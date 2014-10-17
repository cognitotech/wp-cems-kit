<?php
/**
* CEMS Event 17 Shortcode
* [cems_event17]
*
* @class              CEMSEvent17Shortcode
* @author             pnghai <nguyenhai@siliconstraits.vn>
* @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
* @date               2014-10-17
* @version            1.0.0
*
*/
class CEMSEvent17Shortcode extends WPDKShortcode {

    /**
     * Create or return a singleton instance of CEMSEvent17Shortcode
     *
     * @brief Create or return a singleton instance of CEMSEvent17Shortcode
     *
     * @return CEMSEvent17Shortcode
     */
    public static function getInstance()
    {
        $instance = null;
        if ( is_null( $instance ) ) {
            $instance = new CEMSEvent17Shortcode();
        }
        return $instance;
    }

    /**
     * Alias of getInstance();
     *
     * @brief Init the shortcode register
     *
     * @return CEMSEvent17Shortcode
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
            'cems_event17' => true
        );
        return $shortcodes;
    }

    /**
     * Display the event form with its full function
     *
     * @brief Display the event form
     *
     * @param array       $attributes    Attribute into the shortcode
     *
     * @return string
     */
    function cems_event17( $attributes ) {
        $formContent = new CEMSEvent17($attributes);
        $output  = $formContent->html();
	    return $output;
    }

}