<?php
/**
* Plugin Name: Wordpress CEMS Kit
* Plugin URI: http://siliconstraits.com
* Description: Wordpress CEMS Kit plugin with full WPDK support
* Version: 1.0.0
* Author: Hai Phan Nguyen
* Author URI: http://siliconstraits.com
* Text Domain:     wp-cems-kit
* License: MIT License
*/

// Include WPDK framework
require_once(  dirname( __FILE__ ) . '/wpdk-production/wpdk.php' );

// Include CEMS-PHP-SDK
require_once( dirname( __FILE__ ) . '/vendor/autoload.php');

// Define of include your main plugin class
if( !class_exists( 'CEMSPlugin' ) )
{

    /**
     * CEMSPlugin is the main class of this plugin, and extends WPDKWordPressPlugin
     *
     * @class              CEMSPlugin
     * @author             pnghai <nguyenhai@siliconstraits.vn>
     * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
     * @date               2014-07-15
     * @version            1.0.0
     *
     */
    final class CEMSPlugin extends WPDKWordPressPlugin {

        /**
         * Create and return a singleton instance of CEMSPlugin class
         *
         * @brief Init
         *
         * @param string $file The main file of this plugin. Usually __FILE__ (main.php)
         *
         * @return CEMSPlugin
         */
        public static function boot( $file = null )
        {
            static $instance = null;
            if ( is_null( $instance ) ) {
                $instance = new self( $file );
                do_action( __CLASS__ );
            }

            return $instance;
        }

        /**
         * Create an instance of CEMSPlugin class
         *
         * @brief Construct
         *
         * @param string $file The main file of this plugin. Usually __FILE__
         *
         * @return CEMSPlugin object instance
         */
        public function __construct($file)
        {

            parent::__construct( $file );

            // Build my own internal defines
            $this->defines();

            // Build environment of plugin autoload of internal classes - this is ALWAYS the first thing to do
            $this->registerClasses();
            // Register shortcode
            add_action( 'wp_loaded', array( 'CEMSEvent17Shortcode', 'init' ) );
            add_action( 'wp_loaded', array( 'CEMSSubscribeFormShortcode', 'init' ) );
            WPDKUIComponents::init()->enqueue( array( WPDKUIComponents::MODAL, WPDKUIComponents::TOOLTIP ));
        }

        /**
         * Register all autoload classes
         *
         * @brief Autoload classes
         */
        private function registerClasses()
        {

            $includes = array(
                $this->classesPath . 'admin/cems-plugin-admin.php' => 'CEMSPluginAdmin',
                $this->classesPath . 'ajax/cems-plugin-ajax-handler.php' => 'CEMSPluginAjaxHandler',
                $this->classesPath . 'core/cems-event17.php' => 'CEMSEvent17',
                $this->classesPath . 'core/cems-subscribe13.php' => 'CEMSSubscribeForm13',
                $this->classesPath . 'core/cems-subscribe14.php' => 'CEMSSubscribeForm14',
                $this->classesPath . 'core/cems-subscribe15.php' => 'CEMSSubscribeForm15',
                $this->classesPath . 'core/cems-subscribe-quiz.php' => 'CEMSSubscribeQuiz',
                $this->classesPath . 'preferences/cems-plugin-preferences.php' => array(
                    'CEMSPluginPreferences',
                    'CEMSPreferencesGeneralBranch',
                    'CEMSPreferencesLayoutBranch',
                    'CEMSPreferencesCustomErrorsBranch'),
                $this->classesPath . 'preferences/cems-plugin-preferences-viewcontroller.php' => array(
                    'CEMSPluginPreferencesViewController',
                    'CEMSPreferencesGeneralView',
                    'CEMSPreferencesLayoutView',
                    'CEMSPreferencesCustomErrorsView'),
                $this->classesPath . 'other/about-viewcontroller.php' => 'AboutViewController',
                $this->classesPath . 'shortcodes/cems-event17-shortcode.php' => 'CEMSEvent17Shortcode',
                $this->classesPath . 'shortcodes/cems-subscribe-form-shortcode.php' => 'CEMSSubscribeFormShortcode',
                $this->classesPath . 'theme/cems-plugin-theme.php' => 'CEMSPluginTheme'
            );

            $this->registerAutoloadClass( $includes );

        }

        /**
         * Include the external defines file
         *
         * @brief Defines
         */
        private function defines()
        {
            include_once( 'defines.php' );
        }

        /**
         * Catch for activation. This method is called one shot.
         *
         * @brief Activation
         */
        public function activation()
        {
            // When you update your plugin it is re-activate. In this place you can update your preferences
            CEMSPluginPreferences::init()->delta();
        }

        /**
         * Catch for admin
         *
         * @brief Admin backend
         */
        public function admin()
        {
            CEMSPluginAdmin::init( $this );
        }

        /**
         * Init your own preferences settings
         *
         * @brief Preferences
         */
        public function preferences()
        {
            CEMSPluginPreferences::init();
        }

        /**
         * Catch for deactivation. This method is called when the plugin is deactivate.
         *
         * @brief Deactivation
         */
        public function deactivation()
        {
            // To override
        }

        // Called when the plugin is loaded
        public function loaded()
        {
            // To override
            //CEMSPreviewEbookShortcode::init();
        }

        // Called only if the web request is related to the front-end side of WordPress
        public function theme()
        {
            // To override
            CEMSPluginTheme::init();
        }

        /**
         * Catch for ajax
         *
         * @brief Ajax
         */
        public function ajax()
        {
            // For example
            CEMSPluginAjaxHandler::init();
        }
    }
}

$GLOBALS['CEMSPlugin'] = CEMSPlugin::boot(__FILE__);
/*
 * TODO: Setup front end Bootstrap button via shortcode
 *
 * TODO: Setup Bootstrap pop up: close button, heading, button for navigation to sub-form
 * TODO: Setup front end form: (1)subscription by email
 * TODO: Setup front end form: (2)register new customer
 *
 * TODO: Detect whether AJAX call and make proper calls to API
 *
 * TODO: (1): return link for user to front end, otherwise goto (2)
 * TODO: (2): return message: success, please check your email, otherwise: notify error (3)
 */