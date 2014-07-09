<?php

/**
 * @class              CEMSPluginPreferencesViewController
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPluginPreferencesViewController extends WPDKPreferencesViewController
{

    /**
     * Return a singleton instance of CEMSPluginPreferencesViewController class
     *
     * @brief Singleton
     *
     * @return CEMSPluginPreferencesViewController
     */
    public static function init()
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Create an instance of CEMSPluginPreferencesViewController class
     *
     * @brief Construct
     *
     * @return CEMSPluginPreferencesViewController
     */
    public function __construct()
    {

        // Single instances of tab content
        $general_view = new CEMSPreferencesGeneralView();
        $layout_view = new CEMSPreferencesLayoutView();

        // Create each single tab
        $tabs = array(
            new WPDKjQueryTab($general_view->id, __('Genral Settings',WPCEMS_TEXTDOMAIN), $general_view->html()),
            new WPDKjQueryTab($layout_view->id, __('Custom CSS Layout',WPCEMS_TEXTDOMAIN), $layout_view->html()),
        );

        parent::__construct(CEMSPluginPreferences::init(), __('Preferences',WPCEMS_TEXTDOMAIN), $tabs);

    }

    /**
     * This static method is called when the head of this view controller is loaded by WordPress.
     * It is used by WPDKMenu for example, as 'admin_head-' action.
     *
     * @brief Head
     */
    public function admin_head()
    {
        // Enqueue pre-register WPDK components
        WPDKUIComponents::init()->enqueue(WPDKUIComponents::CONTROLS, WPDKUIComponents::TOOLTIP);

        // Enqueue your own styles and scripts
        wp_enqueue_script( 'wpcems-preferences', WPCEMS_URL_JAVASCRIPT . 'wpcems-preferences.js', array( 'jquery' ), WPCEMS_VERSION, true );
        wp_enqueue_style( 'wpcems-preferences', WPCEMS_URL_CSS . 'wpcems-preferences.css', array(), WPCEMS_VERSION );
    }

}

/**
 * Description
 *
 * @class           CEMSPreferencesGeneralView
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPreferencesGeneralView extends WPDKPreferencesView
{

    /**
     * Create an instance of CEMSPreferencesGeneralView class
     *
     * @brief Construct
     *
     * @return CEMSPreferencesGeneralView
     */
    public function __construct()
    {
        $preferences = CEMSPluginPreferences::init();

        parent::__construct($preferences, 'general');
    }

    /**
     * Return a sdf array for form fields
     *
     * @brief Return array for form fields
     *
     * @param CEMSPreferencesGeneralBranch $general
     *
     * @return array
     */
    public function fields( $general )
    {

        $fields = array(

            __( 'Xác thực dịch vụ CEMS API', WPCEMS_TEXTDOMAIN ) => array(

                __( 'Nhập thông tin bên dưới để truy cập dịch vụ CEMS API.', WPCEMS_TEXTDOMAIN ),

                __( 'Nếu bạn không có access token, hoặc muốn đổi tài khoản; xin hãy để trống bước nhập Access Token và nhập tiếp thông tin dưới đây', WPCEMS_TEXTDOMAIN ),

                array(
                    array(
                        'type'  => WPDKUIControlType::TEXT,
                        'name'  => CEMSPreferencesGeneralBranch::API_URL,
                        'label' => __( 'API Url', WPCEMS_TEXTDOMAIN ),
                        'placeholder' => __('Nhập CEMS API url', WPCEMS_TEXTDOMAIN ),
                        'title'       => __('CEMS API Url có dạng http://v3.cems.vn', WPCEMS_TEXTDOMAIN ),
                        'value' => $general->api_url
                    )
                ),

                array(
                    array(
                        'type'  => WPDKUIControlType::TEXT,
                        'name'  => CEMSPreferencesGeneralBranch::API_ACCESS_TOKEN,
                        'label' => __( 'API Access Token', WPCEMS_TEXTDOMAIN ),
                        'placeholder' => __('Nhập Access Token', WPCEMS_TEXTDOMAIN ),
                        'title'       => __('Access Token được cấp để truy xuất API từ CEMS', WPCEMS_TEXTDOMAIN ),
                        'value' => $general->api_token
                    )
                ),

                array(
                    array(
                        'type'  => WPDKUIControlType::EMAIL,
                        'name'  => CEMSPreferencesGeneralBranch::API_EMAIL,
                        'label' => __( 'Email', WPCEMS_TEXTDOMAIN ),
                        'placeholder' => __('Nhập email đăng nhập vào CEMS', WPCEMS_TEXTDOMAIN ),
                        'title'       => __('CEMS Email', WPCEMS_TEXTDOMAIN ),
                        'value' => ''
                    )
                ),

                array(
                    array(
                        'type'  => WPDKUIControlType::PASSWORD,
                        'name'  => CEMSPreferencesGeneralBranch::API_PASSWORD,
                        'label' => __( 'Mật khẩu', WPCEMS_TEXTDOMAIN ),
                        'title'       => __('CEMS Password', WPCEMS_TEXTDOMAIN ),
                        'value' => ''
                    )
                ),
            )
        );

        return $fields;
    }

}


/**
 * Layout preferences view
 *
 * @class           CEMSPreferencesLayoutView
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPreferencesLayoutView extends WPDKPreferencesView {

    /**
     * Create an instance of CEMSPreferencesLayoutView class
     *
     * @brief Construct
     *
     * @return CEMSPreferencesLayoutView
     */
    public function __construct()
    {
        $preferences = CEMSPluginPreferences::init();
        parent::__construct( $preferences, 'layout' );
    }

    /**
     * Return a sdf array for form fields
     *
     * @brief Return array for form fields
     *
     * @param CEMSPreferencesLayoutBranch $layout
     *
     * @return array
     */
    public function fields( $layout )
    {

        $fields = array(
            __( 'CSS inline style', WPCEMS_TEXTDOMAIN ) => array(
                array(
                    array(
                        'type'  => WPDKUIControlType::SWIPE,
                        'name'  => CEMSPreferencesLayoutBranch::CSS_STYLE_ENABLED,
                        'label' => __( 'Kích hoạt', WPCEMS_TEXTDOMAIN ),
                        'value' => $layout->css_style_enabled
                    )
                ),
                array(
                    array(
                        'type'  => WPDKUIControlType::TEXTAREA,
                        'name'  => CEMSPreferencesLayoutBranch::CSS_STYLE,
                        'label' => __( 'CSS Style', WPCEMS_TEXTDOMAIN ),
                        'value' => $layout->css_style
                    )
                )

            )
        );

        return $fields;
    }
}
