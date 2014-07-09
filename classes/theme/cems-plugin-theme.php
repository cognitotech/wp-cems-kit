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
class CEMSPluginTheme extends WPDKTheme{
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

        // Include functions
        require_once( WPCEMS_PATH_CLASSES . 'core/wpxbz-functions.php' );
    }

    /**
     * Called by `wp_enqueue_scripts` action. You will use this action to register (do a queue) scripts and styles.
     *
     * @brief WordPress action for scripts and styles
     */
    public function wp_enqueue_scripts()
    {
        // Added styles and script for frontend
        wp_enqueue_script( 'wpcems-ebooksubscription', WPCEMS_URL_JAVASCRIPT . 'cems-ebooksubscription.js', array( 'jquery' ), WPCEMS_VERSION, true );
        wp_enqueue_script( 'wpcems-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array( 'jquery' ));
        wp_enqueue_script( 'wpcems-validate', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js', array( 'jquery' ));
        wp_enqueue_script( 'wpcems-validate-messages', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/localization/messages_vi.js', array( 'jquery' ));
        wp_enqueue_style( 'wpcems-theme', WPCEMS_URL_CSS . 'cems-theme.css', array(), WPCEMS_VERSION );
        wp_enqueue_style( 'wpcems-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', array());
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
            <?php echo CEMSPluginPreferences::init()->layout->css_style ?>
        </style>
        <?php endif; ?>

        <?php
        echo WPDKHTML::endCSSCompress();
    }

} 