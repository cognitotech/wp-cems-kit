<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:30 PM
 */

/**
 * Front end for CEMS Toolkit
 *
 * @class           CEMSPluginTheme
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPluginTheme extends WPDKWordPressTheme{
    /**
     * Return a singleton instance of CEMSPluginTheme class
     *
     * @brief Singleton
     *
     * @return CEMSPluginTheme
     */
    public static function init()
    {
        static $instance = null;
        if ( is_null( $instance ) ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Create an instance of CEMSPluginTheme class
     *
     * @brief Construct
     *
     * @return CEMSPluginTheme
     */
    public function __construct()
    {
        /**
         * @var CEMSPlugin $plugin
         */
        $plugin = $GLOBALS['CEMSPlugin'];

        parent::__construct( $plugin );

    }

    /**
     * Called by `wp_enqueue_scripts` action. You will use this action to register (do a queue) scripts and styles.
     *
     * @brief WordPress action for scripts and styles
     */
    public function wp_enqueue_scripts()
    {
        wp_enqueue_script( 'wpcems-browser', '//cdnjs.cloudflare.com/ajax/libs/jquery-browser/0.0.6/jquery.browser.min.js', array('jquery'), false, true );
        wp_enqueue_script( 'wpcems-migrate', '//code.jquery.com/jquery-migrate-1.2.1.min.js', array('jquery'), false, true );
        // Added styles and script for frontend
        wp_enqueue_script( 'wpcems-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), false, true );
        wp_enqueue_script( 'wpcems-bootstrap-datepicker', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js', array('wpcems-bootstrap'), false, true );
        wp_enqueue_script( 'wpcems-bootstrap-datepicker-vi', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/locales/bootstrap-datepicker.vi.min.js', array('wpcems-bootstrap-datepicker'), false, true );
        wp_enqueue_script( 'wpcems-moment', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.3/moment.min.js', array(), false, true );
        wp_enqueue_script( 'wpcems-bootstrapvalidator', '//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js', array( 'wpcems-bootstrap','wpcems-moment' ), false, true );
        wp_enqueue_script( 'wpcems-chosen', '//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'wpcems-customer_source', WPCEMS_URL_JAVASCRIPT . 'customer_source.min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'wpcems-event17', WPCEMS_URL_JAVASCRIPT . 'cems-event17.min.js', array( 'wpcems-bootstrapvalidator','wpcems-bootstrap-datepicker'), false, true );

        wp_enqueue_style( 'wpcems-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',array(),false);

        wp_enqueue_style( 'wpcems-theme', WPCEMS_URL_CSS . 'cems-theme.css', array(),false);
        wp_enqueue_style( 'wpcems-chosen', '//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css',array(),false);
        wp_enqueue_style( 'wpcems-bootstrap-chosen', WPCEMS_URL_CSS . 'bootstrap-chosen.min.css', array(),false);
        wp_enqueue_style( 'wpcems-bootstrap-datepicker', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css', array(),false);
        wp_enqueue_style( 'wpcems-bootstrap-datepicker3', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css', array(),false);
        wp_enqueue_style( 'wpcems-bootstrapvalidator', '//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css',array(),false);
    }

    /**
     * Output the custom css style
     *
     * @brief CSS style
     * @since 1.2.0
     */
    public function wp_head()
    {
        WPDKUIComponents::init()->enqueue( WPDKUIComponents::WPDK );

        WPDKHTML::startCompress(); ?>

        <?php if ( wpdk_is_bool( CEMSPluginPreferences::init()->layout->css_style_enabled ) ) : ?>
        <!-- CEMS Custom CSS -->
        <style type="text/css">
            <?php echo CEMSPluginPreferences::init()->layout->css_style; ?>
        </style>
        <?php endif; ?>

        <?php
        echo WPDKHTML::endCSSCompress();
    }

} 