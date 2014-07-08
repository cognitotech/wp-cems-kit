<?php
/**
* CEMS Preview E-book Shortcode
*
* @class              CEMSPreviewEbookShortcode
* @author             pnghai <nguyenhai@siliconstraits.vn>
* @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
* @date               2014-07-15
* @version            1.0.0
*
*/
class CEMSPreviewEbookShortcode extends WPDKShortcode {

    /**
     * Create or return a singleton instance of CEMSPreviewEbookShortcode
     *
     * @brief Create or return a singleton instance of CEMSPreviewEbookShortcode
     *
     * @return CEMSPreviewEbookShortcode
     */
    public static function getInstance()
    {
        $instance = null;
        if ( is_null( $instance ) ) {
            $instance = new CEMSPreviewEbookShortcode();
        }
        return $instance;
    }

    /**
     * Alias of getInstance();
     *
     * @brief Init the shortcode register
     *
     * @return CEMSPreviewEbookShortcode
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
            'cems_preview_ebook' => true
        );
        return $shortcodes;
    }

    function cems_preview_ebook( $attributes ) {
        $a = shortcode_atts( array(
            'list_id' => '-1'
        ), $attributes );

        ob_start();
        //#TODO: print button here
        echo $a['list_id'];
	    return ob_get_clean();
    }

}