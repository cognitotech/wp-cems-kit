<?php
/**
 * User: Viet Trinh
 * Date: 07/02/2015
 * Time: 11:41 AM
 */

class CEMSDatabase {
	/**
	 * Version of database, not compare with version of plugin
	 */
	const version = 1;

	/**
	 * All table name
	 **/
	private $table_subscribers = null; // table subccriber_list
	private $table_custom_msg = null; // table custom_msg
	
	protected $list_custom_msg = array( 'subscription_success' => '' );
	
	static function get_table_subscribers_name(){
		global $wpdb;
		return ($wpdb->prefix . "cems_subscribers");
	}
	static function get_table_custom_msg_name(){
		global $wpdb;
		return ($wpdb->prefix . "cems_custom_msg");
	}
	static function get_list_custom_msg_key(){
		return array(
			'subscription_success' => 'Success message',
			'waiting_message' => 'Waiting message'
		);
	}
	
	
	
	/**
	 * Declare construct
	 */
	function __construct(){
		global $wpdb;
		$this->table_subscribers = $wpdb->prefix . "cems_subscribers";
		$this->table_custom_msg = $wpdb->prefix . "cems_custom_msg";
	}

	/**
	 * @return int version of database
	 */
	public static function init_database(){
		(new CEMSDatabase())->create_or_update_database();
	}

	/**
	 * @return int version of database
	 */
	function get_version(){return $this->version;}

	/**
	 * @return none
	 */
	private function create_or_update_database(){
		global $wpdb;
		////
		// frist do create database if not exists
		////
		$sql_str = "CREATE TABLE IF NOT EXISTS `{$this->table_subscribers}` ( "
					. "`list_id` INT UNSIGNED NOT NULL, "
					. "`list_name` VARCHAR(200) NOT NULL, "
					. "`html_code` TEXT NULL DEFAULT NULL, "
					. "`custom_css` TEXT NULL DEFAULT NULL, "
					. "`custom_script` TEXT NULL DEFAULT NULL, "
					. "PRIMARY KEY (`list_id`) "
					. ")".$wpdb->get_charset_collate();
		$wpdb->query( $sql_str ); $wpdb->flush();
		
		$sql_str = "CREATE TABLE IF NOT EXISTS `{$this->table_custom_msg}`( "
					. "`list_id` INT UNSIGNED NOT NULL, "
					. "`custom_key` NVARCHAR(30) NOT NULL, "
					. "`custom_msg` TEXT NULL DEFAULT NULL, "
					. "PRIMARY KEY (`list_id`,`custom_key`) "
					. ")".$wpdb->get_charset_collate();
		$wpdb->query( $sql_str ); $wpdb->flush();

		////
		//next step do upgrade database with list function database
		////
	}

}