<?php

/**
 * This is the main admin class of your plugin. It extends the basic class WPDKWordPressAdmin, that gives you some facilities to handle operation in WordPress administrative
 * area.
 *
 * @class              CEMSPluginAdmin
     * @author             pnghai <nguyenhai@siliconstraits.vn>
     * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
     * @date               2014-07-15
     * @version            1.0.0
     *
     */
class CEMSPluginAdmin extends WPDKWordPressAdmin {

    /**
     * This is the minimum capability required to display admin menu item
     *
     * @brief Menu capability
     */
    const MENU_CAPABILITY = 'manage_options';

    /**
     * Create and return a singleton instance of CEMSPluginAdmin class
     *
     * @brief Init
     *
     * @return CEMSPluginAdmin
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
     * Create an instance of CEMSPluginAdmin class
     *
     * @brief Construct
     *
     * @return CEMSPluginAdmin
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
     * Called by WPDKWordPressAdmin parent when the admin head is loaded
     *
     * @brief Admin head
     */
    public function admin_head()
    {
        // You can enqueue here all the scripts and css styles needed by your plugin, through wp_enqueue_script and wp_enqueue_style functions   */
    }

    /**
     * Called when WordPress is ready to build the admin menu.
     *
     * @brief Admin menu
     */
    public function admin_menu()
    {

        // Load my own icon

        // Build menu as an array. See documentation of method renderByArray of class WPDKMenu for details
        $menus = array(
            'wp_cems_plugin' => array(

                // Menu title shown as first entry in main navigation menu
                'menuTitle'  => __( 'CEMS V3 Toolkit',WPCEMS_TEXTDOMAIN),

                // WordPress capability needed to see this menu - if current WordPress user does not have this capability, the menu will be hidden
                'capability' => self::MENU_CAPABILITY,

                // Icon to show in menu - see above
                'icon'       => WPCEMS_LOGO,

                // Create two sub-menu item to this main menu
                'subMenus'   => array(

                    array(
                        'menuTitle'      => __( 'General Settings',WPCEMS_TEXTDOMAIN ), // Menu item shown as first sub-menu in main navigation menu
                        'pageTitle'      => __( 'CEMS Toolkit Configuration',WPCEMS_TEXTDOMAIN ),  // The web page title shown when this item is clicked

                        // WordPress capability needed to see this menu item - if current WordPress user does not have this capability, this menu item will be hidden
                        'capability'     => self::MENU_CAPABILITY,
                        'viewController' => 'CEMSPluginPreferencesViewController', // Function called whenever this menu item is clicked
                    ),
                    
                    array(
                        'menuTitle'      => __( 'Subscriber List',WPCEMS_TEXTDOMAIN ), // Menu item shown as first sub-menu in main navigation menu
                        'pageTitle'      => __( 'CEMS Subscriber List',WPCEMS_TEXTDOMAIN ),  // The web page title shown when this item is clicked

                        // WordPress capability needed to see this menu item - if current WordPress user does not have this capability, this menu item will be hidden
                        'capability'     => self::MENU_CAPABILITY,
                        'viewController' => 'CEMSSubscriberListViewController', // Function called whenever this menu item is clicked
                    ),

                    // Add a divider to separate the first sub-menu item from the second
                    WPDKSubMenuDivider::DIVIDER,

                    array(
                        'menuTitle'      => __( 'About',WPCEMS_TEXTDOMAIN ),
                        'pageTitle'      => __( 'About CEMS Toolkit',WPCEMS_TEXTDOMAIN ),
                        'viewController' => 'AboutViewController',
                    ),
                )
            )
        );

        // Physically build the menu added to main navigation menu when this plugin is activated
        WPDKMenu::renderByArray( $menus );

    }

}
