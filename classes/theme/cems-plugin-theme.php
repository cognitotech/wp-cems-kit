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
        wp_deregister_script('jquery');
        wp_register_script('jquery', ("http://code.jquery.com/jquery-latest.min.js"));
        wp_enqueue_script('jquery');
        // Added styles and script for frontend
        wp_enqueue_script( 'wpcems-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), false, true );
        wp_enqueue_script( 'wpcems-bootstrapvalidator', '//cdn.jsdelivr.net/jquery.bootstrapvalidator/0.4.5/js/bootstrapValidator.min.js', array( 'wpcems-bootstrap' ), false, true );
        wp_enqueue_script( 'wpcems-ebooksubscription', WPCEMS_URL_JAVASCRIPT . 'cems-ebooksubscription.js', array( 'wpcems-bootstrapvalidator' ), false, true );
        wp_enqueue_style( 'wpcems-theme', WPCEMS_URL_CSS . 'cems-theme.css', array(),false);
        wp_enqueue_style( 'wpcems-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',array(),false);
        wp_enqueue_style( 'wpcems-bootstrapvalidator', '//cdn.jsdelivr.net/jquery.bootstrapvalidator/0.4.5/css/bootstrapValidator.min.css',array(),false);
    }

    /**
     * Output the custom css style
     *
     * @brief CSS style
     * @since 1.2.0
     */
    public function wp_head()
    {
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