<?php

/**
 * @class              CEMSPluginPreferencesViewController
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPluginPreferencesViewController extends WPDKPreferencesViewController {

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
    if ( is_null( $instance ) ) {
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

    // Create the single view for each tab
    $settings_view = new CEMSPluginPreferencesSettingsBranchView();

    // Create each single tab
    $tabs = array(
      new WPDKjQueryTab( $settings_view->id, __( 'Settings' ), $settings_view->html() ),
    );

    parent::__construct( CEMSPluginPreferencesModel::init(), __( 'Preferences' ), $tabs );

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
    WPDKUIComponents::init()->enqueue( WPDKUIComponents::CONTROLS, WPDKUIComponents::TOOLTIP );

    // Enqueue your own styles and scripts
  }

}

/**
 * Description
 *
 * @class           CEMSPluginPreferencesSettingsBranchView
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPluginPreferencesSettingsBranchView extends WPDKPreferencesView {

  /**
   * Create an instance of CEMSPluginPreferencesSettingsBranchView class
   *
   * @brief Construct
   *
   * @return CEMSPluginPreferencesSettingsBranchView
   */
  public function __construct()
  {
    $preferences = CEMSPluginPreferencesModel::init();

    // In your model you have a property named 'settings', so you must used the same name
    parent::__construct( $preferences, 'settings' );
  }

  /**
   * Return the array fields
   *
   * @brief Fields
   *
   * @param MySettingBranch $settings
   *
   * @return array|void
   */
  public function fields( $settings )
  {
    $fields = array(

      __( 'First area' ) => array(

        __( 'This area contains only a input text box - Insert here a short description of this area, in terms of controls that it owns, or whatever you want' ),

        array(
          array(
            'type'        => WPDKUIControlType::TEXT,
            'name'        => MySettingBranch::MY_VALUE,
            'label'       => 'A text box',
            'placeholder' => 'I am a placeholder',
            'title'       => 'I am a tooltip for control WPDKUIControlType::TEXT',
            'value'       => $settings->value_text_box
          ),
        ),

      ),

      'Second Area'      => array(
        'This area contains a subset of other <em>WPDK graphic controls</em> - Insert here a short description of this area, in terms of controls that it owns, or whatever you want',
        array(
          array(
            'type'    => WPDKUIControlType::CHECKBOX,
            'name'    => 'value_check_box',
            'label'   => 'Check me',
            'value'   => 'is_checked',
            'checked' => $settings->value_check_box
          )
        ),
        array(
          array(
            'type'    => WPDKUIControlType::SELECT,
            'label'   => 'Select an item',
            'name'    => 'value_combo_box',
            'options' => array(
              'one'   => 'Rome',
              'two'   => 'Milan',
              'three' => 'Paris'
            ),
            'value'   => $settings->value_combo_box
          ),

        ),

        'This is an <strong>amazing swipe control!</strong>',

        array(
          array(
            'type'  => WPDKUIControlType::SWIPE,
            'name'  => 'value_swipe',
            'label' => 'Swipe me',
            'title' => 'Swipe me to display an alert',
            'value' => $settings->value_swipe
          )
        )
      )
    );

    return $fields;
  }
}
