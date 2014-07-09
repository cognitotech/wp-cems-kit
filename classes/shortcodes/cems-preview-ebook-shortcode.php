<?php
/**
* CEMS Preview E-book Shortcode
* [cems_preview_ebook list_id=-1 book_title='']
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

    /**
     * Display the preview button with its full function
     *
     *     $defaults = array(
     *      'list_id' => -1,
     *      'book_title' => '',
     *     );
     *
     * @brief Display the preview button
     *
     * @param array       $attributes    Attribute into the shortcode
     *
     * @return string
     */
    function cems_preview_ebook( $attributes ) {
        $output = '';
        $defaults = array(
            'list_id' => -1,
            'book_title' => '',
        );
        $attributes = shortcode_atts( $defaults, $attributes, 'cems_preview_ebook' );

        $previewContent = new CEMSPreviewEbook( $attributes );
        $output  = $previewContent->html();
	    return $output;
    }

}