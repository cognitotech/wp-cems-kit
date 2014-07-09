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

        $this->api_url = esc_attr($_POST[self::API_URL]);
        if (isset($_POST[self::API_ACCESS_TOKEN])) {
            $this->api_token = esc_attr($_POST[self::API_ACCESS_TOKEN]);
        } else {
            if ((isset($_POST[self::API_EMAIL])) && (isset($_POST[self::API_PASSWORD]))) {
                $email = esc_attr($_POST[self::API_EMAIL]);
                $pass = esc_attr($_POST[self::API_PASSWORD]);
                $client = new CEMS\Client($email, $pass, $this->api_token);
                $this->api_token=$client->getAccessToken();
            }
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