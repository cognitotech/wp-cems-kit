<?php

class CEMSSubscriberList extends WPDKPreferences {

	/**
	 * The Preferences name used on database
	 *
	 * @brief Preferences name
	 *
	 * @var string
	 */
	const PREFERENCES_NAME = 'wpcems-subscriber-list';

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
	public $create_subscriber_form;

	/**
	 * Edit subscriber form
	 * 
	 */
	public $edit_subscriber_form;

	/**
	 * Error Message
	 *
	 * @brief Layout
	 * @since 1.2.0
	 *
	 * @var CEMSPreferencesCustomErrorsBranch
	 */
	public $error_messages;

	/**
	 * Return an instance of CEMSPluginPreferences class from the database.
	 *
	 * @brief Init
	 *
	 * @return CEMSPluginPreferences
	 */
	public static function init() {
		return parent::init( self::PREFERENCES_NAME, __CLASS__, WPCEMS_VERSION );
	}

	/**
	 * Set the default preferences
	 *
	 * @brief Default preferences
	 */
	public function defaults() {
		$this->create_subscriber_form = new CEMSCreateSubscriberFormBranch();
		$this->edit_subscriber_form = new CEMSEditSubscriberFormBranch();
	}

}

/**
 * CEMS Create Subscribe Form preferences branch model
 *
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSCreateSubscriberFormBranch extends WPDKPreferencesBranch {

	// You can define your post field constants
	const LIST_ID = 'wpcems_new_form_id';
	const LIST_NAME = 'wpcems_new_form_name';
	const HTML_CODE = 'wpcems_new_html_code';
	const CUSTOM_CSS = 'wpcems_new_custom_css';
	const CUSTOM_SCRIPT = 'wpcems_new_custom_script';

	// Interface of preferences branch
	public $list_id;
	public $list_name;
	public $html_code;
	public $custom_css;
	public $custom_script;
	public $error;

	/**
	 * Set the default preferences
	 *
	 * @brief Default preferences
	 */
	public function defaults() {
		// Set the default for the first time or reset preferences
		$this->list_id = '';
		$this->list_name = '';
		$this->html_code = '';
		$this->custom_css = '';
		$this->custom_script = '';
	}

	/**
	 * Update this branch
	 *
	 * @brief Update
	 */
	public function update() {
		// Update and sanitize from post data
		if ( strlen( $_POST[self::LIST_ID] ) > 0 && is_numeric( $_POST[self::LIST_ID] ) &&
				strlen( $_POST[self::LIST_NAME] ) > 0
		) {
			$this->list_id = wp_slash( $_POST[self::LIST_ID] );
			$this->list_name = wp_slash( esc_attr( $_POST[self::LIST_NAME] ) );
			$this->html_code = wp_slash( esc_html( $_POST[self::HTML_CODE] ) );
			$this->custom_css = base64_encode(serialize( $_POST[self::CUSTOM_CSS] ) );
			$this->custom_script = base64_encode(serialize( $_POST[self::CUSTOM_SCRIPT] ) );
			
			/**
			 * Check exists
			 * exists -> do update
			 * else -> do insert
			 * */
			global $wpdb;
			$table_name = CEMSDatabase::get_table_subscribers_name();
			$sql_str = "INSERT INTO `{$table_name}`(`list_id`, `list_name`, `html_code`, `custom_css`, `custom_script`) VALUES ( '{$this->list_id}', '{$this->list_name}', '{$this->html_code}', '{$this->custom_css}', '{$this->custom_script}');";
			$wpdb->query( $sql_str );
			
			//insert custom message
			$list_custom_msg = CEMSDatabase::get_list_custom_msg_key();
			$table_name = CEMSDatabase::get_table_custom_msg_name();
			foreach($list_custom_msg as $key => $value){
				$text = wp_slash($_POST[$key]);
				$sql_str = "INSERT INTO `{$table_name}`(`list_id`,`custom_key`,`custom_msg`) VALUES ('{$this->list_id}','{$key}','{$text}')";
				$wpdb->query( $sql_str );
			}
			
		} else {
			wp_die( 'Form ID and Form Name can\'t be null!.' );
		}
	}

}

/**
 * CEMS Edit Subscribe Form preferences branch model
 *
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSEditSubscriberFormBranch extends WPDKPreferencesBranch {

	// You can define your post field constants
	const LIST_ID = 'wpcems_edit_form_id';
	const LIST_NAME = 'wpcems_edit_form_name';
	const HTML_CODE = 'wpcems_edit_html_code';
	const CUSTOM_CSS = 'wpcems_edit_custom_css';
	const CUSTOM_SCRIPT = 'wpcems_edit_custom_script';

	// Interface of preferences branch
	public $list_id;
	public $list_name;
	public $html_code;
	public $custom_css;
	public $custom_script;
	public $error;

	/**
	 * Set the default preferences
	 *
	 * @brief Default preferences
	 */
	public function defaults() {
		// Set the default for the first time or reset preferences
		$this->list_id = '';
		$this->list_name = '';
		$this->html_code = '';
		$this->custom_css = '';
		$this->custom_script = '';
	}

	/**
	 * Update this branch
	 *
	 * @brief Update
	 */
	public function update() {
		//var_dump($_POST);
		// Update and sanitize from post data
		if ( 	isset( $_POST['old_' . self::LIST_ID] ) && strlen( $_POST['old_' . self::LIST_ID] ) > 0 && is_numeric( $_POST['old_' . self::LIST_ID] ) &&
					isset( $_POST[self::LIST_ID] ) && strlen( $_POST[self::LIST_ID] ) > 0 && is_numeric( $_POST[self::LIST_ID] ) &&
					isset( $_POST[self::LIST_NAME] ) && strlen( $_POST[self::LIST_NAME] ) > 0
				 
		) {
			$old_list_id = $_POST['old_' . self::LIST_ID];
			$this->list_id = wp_slash( $_POST[self::LIST_ID] );
			$this->list_name = wp_slash( esc_attr( $_POST[self::LIST_NAME] ) );
			$this->html_code = wp_slash( esc_html( $_POST[self::HTML_CODE] ) );
			$this->custom_css = base64_encode(serialize( $_POST[self::CUSTOM_CSS] ) );
			$this->custom_script = base64_encode(serialize( $_POST[self::CUSTOM_SCRIPT] ) );

			/**
			 * Check exists
			 * exists -> do update
			 * else -> do insert
			 * */
			global $wpdb;
			$table_name = CEMSDatabase::get_table_subscribers_name();
			$sql_str = "UPDATE $table_name SET list_id = '{$this->list_id}', list_name = '{$this->list_name}', html_code = '{$this->html_code}', custom_css = '{$this->custom_css}', custom_script = '{$this->custom_script}' WHERE list_id = '{$old_list_id}'";
			$wpdb->query( $sql_str );
			$sql_str = "UPDATE {$table_name} SET list_id = '{$this->list_id}' WHERE list_id = '{$old_list_id}'";
			
			//update custom message
			$list_custom_msg = CEMSDatabase::get_list_custom_msg_key();
			$table_name = CEMSDatabase::get_table_custom_msg_name();
			//frist before update value of msg, do update list id if have change
			$wpdb->query( $sql_str );
			$sql_str = "UPDATE {$table_name} SET list_id = '{$this->list_id}' WHERE list_id = '{$old_list_id}'";
			
			//now do update or delete 
			foreach($list_custom_msg as $key => $value){
				/*
				 * If isset $key and not null & string length > 0 => update
				 */
				
				if ( isset($_POST[$key]) && strlen(trim($_POST[$key].'')) > 0 ){
					//do update or insert
					/* check value */
					$text = wp_slash($_POST[$key]);
					
					/* count if have  */
					$sql_str = "SELECT COUNT(*) FROM `{$table_name}` WHERE `list_id`={$this->list_id} AND `custom_key`='{$key}'";
					$result = $wpdb->get_results($sql_str, ARRAY_N);
					
					/* if exists custom_key -> do update, else -> do insert */
					if (count($result) > 0 && $result[0][0] > 0){
						$sql_str = "UPDATE `{$table_name}` SET `custom_msg` = '{$text}' WHERE `list_id`={$this->list_id} AND `custom_key`='{$key}'";
					}else{
						$sql_str = "INSERT INTO `{$table_name}`(`list_id`,`custom_key`,`custom_msg`) VALUES ('{$this->list_id}','{$key}','{$text}')";
					}
				}else{
					//do delete if exists
					$sql_str = "DELETE FROM {$table_name} WHERE `list_id`={$this->list_id} AND `custom_key`='{$key}'";
				}
				
				$wpdb->query( $sql_str );
			}
		} else {
			wp_die( 'Form ID and Form Name can\'t be null!.' );
		}
	}

}
