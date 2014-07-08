/**
* Plugin Name: Wordpress CEMS Kit
* Plugin URI: http://siliconstraits.com
* Description: Worpress CEMS Kit plugin with full WPDK support
* Version: 1.0.0
* Author: Hai Phan Nguyen
* Author URI: http://siliconstraits.com
* Text Domain:     wp-cems-kit
*/
<?php

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
                $this->classesPath . 'preferences/cems-plugin-preferences.php' => 'CEMSPluginPreferencesModel',
                $this->classesPath . 'preferences/cems-plugin-preferences-viewcontroller.php' => 'CEMSPluginPreferencesViewController',
                $this->classesPath . 'other/about-viewcontroller.php' => 'AboutViewController',
                $this->classesPath . 'ajax/cems-plugin-ajax-handler.php' => 'CEMSPluginAjaxHandler'
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
            CEMSPluginPreferencesModel::init()->delta();
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
            CEMSPluginPreferencesModel::init();
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
            CEMSPreviewEbookShortcode::init();
        }

        // Called only if the web request is related to the front-end side of WordPress
        public function theme()
        {
            // To override
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
$GLOBALS['CEMSPlugin'] = new CEMSPlugin(__FILE__);