<?php

/**
 * CEMS Subscriber List Shortcode
 * [cems_subscriber_list form_id="id"]
 *
 * @class              CEMSSubscriberListShortcode
 * @author             Viet Trinh <quocviet@ssf.vn>
 * @copyright          Copyright (C) 2015 Silicon Straits Saigon. All Rights Reserved.
 * @date               2015-02-25
 * @version            1.0.0
 *
 */
class CEMSSubscriberListShortcode extends WPDKShortcode {

	/**
	 * Create or return a singleton instance of CEMSSubscriberListShortcode
	 *
	 * @brief Create or return a singleton instance of CEMSSubscriberListShortcode
	 *
	 * @return CEMSSubscriberListShortcode
	 */
	public static function getInstance() {
		$instance = null;
		if ( is_null( $instance ) ) {
			$instance = new CEMSSubscriberListShortcode();
		}
		return $instance;
	}

	/**
	 * Alias of getInstance();
	 *
	 * @brief Init the shortcode register
	 *
	 * @return CEMSSubscriberListShortcode
	 */
	public static function init() {
		return self::getInstance();
	}

	/**
	 * Return the array with the list of allowed shortcode
	 *
	 * @brief Preview Subscription Button shortcode
	 *
	 * @return array
	 */
	function shortcodes() {
		$shortcodes = array(
			'cems_subscriber_list' => true
		);
		return $shortcodes;
	}
	
	function unicode_escape_sequences($original_string){
		$replacedString = preg_replace("/\\\\u([0-9abcdef]{4})/", "&#x$1;", $original_string);
		$unicodeString = mb_convert_encoding($replacedString, 'UTF-8', 'HTML-ENTITIES');
		return $unicodeString;
	}

	/**
	 * Display the preview button with its full function
	 *
	 *     $defaults = array(
	 *      'form_id' => -1,
	 *     );
	 *
	 * @brief Display the preview button
	 *
	 * @param array       $attributes    Attribute into the shortcode
	 *
	 * @return string
	 */
	function cems_subscriber_list( $attributes ) {
		$output = '';
		$defaults = array(
			'list_id' => -1,
		);
		$attributes = shortcode_atts( $defaults, $attributes, 'cems_subscriber_list' );
		extract( $attributes );

		global $wpdb;
		$table_name = CEMSDatabase::get_table_subscribers_name(); // get substable name
		$sql_str = "SELECT * FROM `{$table_name}` WHERE list_id = {$list_id} LIMIT 1";
		$subscriber_form = $wpdb->get_results( $sql_str, ARRAY_A );

		$content = '';
		WPDKHTML::startCompress();
		if ( count( $subscriber_form ) > 0 ) {
			/* get all custom_msg & all custom msg key */
			$table_name = CEMSDatabase::get_table_custom_msg_name();
			$sql_str = "SELECT custom_key, custom_msg FROM `{$table_name}` WHERE list_id = {$list_id}";
			$arr_custom_msg = $wpdb->get_results($sql_str, ARRAY_A);
			$json_custom_msg = json_encode($arr_custom_msg,JSON_UNESCAPED_UNICODE);
			if ($json_custom_msg == NULL) // do some thing else if is old version php
				$json_custom_msg = $this->unicode_escape_sequences( json_encode($arr_custom_msg) );
			
			if ( strlen( $subscriber_form[0]['custom_css'] ) > 0 ) //get & decode custom css
				$content .= '<style type="text/css">' ."\r\n" . stripslashes_deep(unserialize( base64_decode( $subscriber_form[0]['custom_css'] ) )) ."\r\n". '</style>'."\r\n";
			
			$content .= '<div class="wp-cems-kit subscriber-form">'."\r\n";
			$content .= stripslashes_deep( html_entity_decode( esc_js( $subscriber_form[0]['html_code'] ) ) ); //get & decode special char
			$content .= "\r\n".'</div>';
			
			if (count($arr_custom_msg) > 0 && strlen($json_custom_msg) > 0)
				$content .= "\r\n".'<script>'. "\r\n" .'form'. $list_id .'='. $json_custom_msg . ";\r\n" .'</script>';
			if ( strlen( $subscriber_form[0]['custom_script'] ) > 0 && strlen(stripslashes_deep(unserialize( base64_decode( $subscriber_form[0]['custom_script'] ) ))) > 0 )//get & decode custom script
				$content .= "\r\n".'<script>'."\r\n". stripslashes_deep(unserialize( base64_decode( $subscriber_form[0]['custom_script'] ) )) . "\r\n". '</script>';
		}
		
		echo $content;
		return WPDKHTML::endCompress();
	}

}
