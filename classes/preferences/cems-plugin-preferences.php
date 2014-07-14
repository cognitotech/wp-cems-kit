<?php

/**
 * Sample preferences class. In this class you define the model of your tree preferences.
 *
 * @class              CEMSPluginPreferences
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPluginPreferences extends WPDKPreferences
{

    /**
     * The Preferences name used on database
     *
     * @brief Preferences name
     *
     * @var string
     */
    const PREFERENCES_NAME = 'wpcems-preferences';

    /**
     * Your own v property
     *
     * @brief Preferences version
     *
     * @var string $version
     */
    public $version = WPCEMS_VERSION;

    /**
     * General Settings
     *
     * @brief General
     *
     * @var CEMSPreferencesGeneralBranch $general
     */
    public $general;

    /**
     * Layout
     *
     * @brief Layout
     * @since 1.2.0
     *
     * @var CEMSPreferencesLayoutBranch
     */
    public $layout;

    /**
     * Error Message
     *
     * @brief Layout
     * @since 1.2.0
     *
     * @var CEMSPreferencesCustomErrorsBranch
     */
    public $errors;
    /**
     * Return an instance of CEMSPluginPreferences class from the database.
     *
     * @brief Init
     *
     * @return CEMSPluginPreferences
     */
    public static function init()
    {
        return parent::init(self::PREFERENCES_NAME, __CLASS__, WPCEMS_VERSION);
    }

    /**
     * Set the default preferences
     *
     * @brief Default preferences
     */
    public function defaults()
    {
        $this->general = new CEMSPreferencesGeneralBranch();
        $this->layout = new CEMSPreferencesLayoutBranch();
        $this->errors = new CEMSPreferencesCustomErrorsBranch();
    }

}

/**
 * CEMS General preferences branch model
 *
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPreferencesGeneralBranch extends WPDKPreferencesBranch
{

    // You can define your post field constants
    const API_URL = 'wpcems_api_url';
    const API_ACCESS_TOKEN = 'wpcems_api_token';
    const API_EMAIL = 'wpcems_email';
    const API_PASSWORD = 'wpcems_password';

    // Interface of preferences branch

    public $api_url;
    public $api_token;

    /**
     * Set the default preferences
     *
     * @brief Default preferences
     */
    public function defaults()
    {
        // Se the default for the first time or reset preferences
        $this->api_url = 'http://v3.cems.vn';
        $this->api_token = '';
    }

    /**
     * Update this branch
     *
     * @brief Update
     */
    public function update()
    {
        // Update and sanitize from post data

        $this->api_url = esc_url_raw($_POST[self::API_URL]);

        if ((strlen($_POST[self::API_EMAIL])>0) && (strlen($_POST[self::API_PASSWORD])>0)) {
            $email = sanitize_email($_POST[self::API_EMAIL]);
            $pass = $_POST[self::API_PASSWORD];

            try {
                $client = new CEMS\Client($email, $pass, $this->api_url);
            }
            catch (CEMS\Error $e) {
                wp_die($e.'\nSome Input Data:'.$this->api_url.' '.$email);
            }
            if (isset($client))
                $this->api_token=$client->getAccessToken();
        }
        else
            if (isset($_POST[self::API_ACCESS_TOKEN])) {
                $this->api_token = esc_attr($_POST[self::API_ACCESS_TOKEN]);
            }
    }

}

/**
 * Layout preferences branch model
 *
 * @class           CEMSPreferencesLayoutBranch
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPreferencesLayoutBranch extends WPDKPreferencesBranch {

    const CSS_STYLE          = 'wpcems_css_style';
    const CSS_STYLE_ENABLED  = 'wpcems_css_style_enabled';
    const PRESET_ORIENTATION = 'wpcems_preset_orientation';

    /**
     * Enabled the CSS inline style
     *
     * @brief Enabled
     *
     * @var string $css_style_enabled
     */
    public $css_style_enabled;

    /**
     * Inline CSS Style
     *
     * @brief CSS Style
     *
     * @var string $css_style
     */
    public $css_style;

    /**
     * Reset to defaults values
     *
     * @brief Reset to default
     */
    public function defaults()
    {
        $this->css_style          = file_get_contents( WPCEMS_PATH_CSS . 'cems-default-inline-style.css' );
        $this->css_style_enabled  = 'off';
    }

    /**
     * Update this branch
     *
     * @brief Update
     */
    public function update()
    {
        $this->css_style          = esc_attr( $_POST[self::CSS_STYLE] );
        $this->css_style_enabled  = esc_attr( $_POST[self::CSS_STYLE_ENABLED] );
    }
}


/**
 * CEMS Custom Error Messages preferences branch model
 *
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPreferencesCustomErrorsBranch extends WPDKPreferencesBranch
{

    // You can define your post field constants
    const ERROR_INVALID_DATA = 'wpcems_error_invalid_data';
    const ERROR_EMAIL_NOT_AVAILABLE = 'wpcems_error_email_not_available';
    const ERROR_EMAIL_NOT_FOUND = 'wpcems_error_email_not_found';
    const ERROR_SUBSCRIPTION_UNKNOWN = 'wpcems_error_subscription_unknown';
    const ERROR_LIST_NOT_FOUND = 'wpcems_error_list_not_found';
    const ERROR_LINK_NOT_FOUND = 'wpcems_error_link_not_found';
    // Interface of preferences branch


    public $invalid_data;
    public $email_not_available;
    public $email_not_found;
    public $subscription_unknown;
    public $list_not_found;
    public $link_not_found;

    /**
     * Set the default preferences
     *
     * @brief Default preferences
     */
    public function defaults()
    {
        // Se the default for the first time or reset preferences
        $this->invalid_data = 'Dữ liệu nhập vào không hợp lệ. Hãy kiểm tra hoặc liên hệ quản trị viên.';
        $this->email_not_available = 'Email đã có hoặc không được phép';
        $this->email_not_found = 'Không tìm thấy email.';
        $this->subscription_unknown = 'Có lỗi xảy ra khi đăng ký với hệ thống. Xin liên hệ admin';
        $this->list_not_found = 'Không tìm thấy ebook';
        $this->link_not_found = 'Không tìm thấy link tải ebook';
    }

    /**
     * Update this branch
     *
     * @brief Update
     */
    public function update()
    {
        // Update and sanitize from post data
        $this->invalid_data = balanceTags( $_POST[self::ERROR_INVALID_DATA] );
        $this->email_not_available  = balanceTags( $_POST[self::ERROR_EMAIL_NOT_AVAILABLE] );
        $this->email_not_found  = balanceTags( $_POST[self::ERROR_EMAIL_NOT_FOUND] );
        $this->subscription_unknown = balanceTags( $_POST[self::ERROR_SUBSCRIPTION_UNKNOWN] );
        $this->list_not_found = balanceTags( $_POST[self::ERROR_LIST_NOT_FOUND] );
        $this->link_not_found = balanceTags( $_POST[self::ERROR_LINK_NOT_FOUND] );
    }

}