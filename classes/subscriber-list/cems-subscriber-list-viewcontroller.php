<?php

/**
 * @class              CEMSSubscriberListsViewController
 * @author             Viet Trinh <quocviet@ssf.vn>
 * @copyright          Copyright (C) 2015 Silicon Straits Saigon. All Rights Reserved.
 * @date               2015-02-25
 * @version            1.0.0
 *
 */
class CEMSSubscriberListViewController extends WPDKPreferencesViewController {

	/**
	 * Create an instance of CEMSPluginPreferencesViewController class
	 *
	 * @brief Construct
	 *
	 * @return CEMSPluginPreferencesViewController
	 */
	public function __construct() {

		//
		$subscriber_table = new CEMSSubscriberTableView();
		$create_subscriber = new CEMSCreateSubscriberView();
		//
		if ( isset( $_POST ) && isset( $_POST['action'] ) ) {
			if ( $_POST['action'] == "Edit" ) {
				$edit_subscriber = new CEMSEditSubscriberView();

				$tabs = array(
					new WPDKjQueryTab( $edit_subscriber->id, __( 'Edit Subscriber Form', WPCEMS_TEXTDOMAIN ), $edit_subscriber->html() ),
					new WPDKjQueryTab( $subscriber_table->id, __( 'Subscriber List', WPCEMS_TEXTDOMAIN ), $subscriber_table->html() ),
					new WPDKjQueryTab( $create_subscriber->id, __( 'Create Subscriber Form', WPCEMS_TEXTDOMAIN ), $create_subscriber->html() ),
				);
			} else if ( $_POST['action'] == "Delete" ) {
				global $wpdb;
				$table_name = CEMSDatabase::get_table_subscribers_name();
				$sql_str = "DELETE FROM {$table_name} WHERE list_id = '{$_POST["list_id"]}'";
				$wpdb->query( $sql_str );

				$tabs = array(
					new WPDKjQueryTab( $subscriber_table->id, __( 'Subscriber List', WPCEMS_TEXTDOMAIN ), $subscriber_table->html() ),
					new WPDKjQueryTab( $create_subscriber->id, __( 'Create Subscriber Form', WPCEMS_TEXTDOMAIN ), $create_subscriber->html() ),
				);
			}
		} else {
			$tabs = array(
				new WPDKjQueryTab( $subscriber_table->id, __( 'Subscriber List', WPCEMS_TEXTDOMAIN ), $subscriber_table->html() ),
				new WPDKjQueryTab( $create_subscriber->id, __( 'Create Subscriber Form', WPCEMS_TEXTDOMAIN ), $create_subscriber->html() ),
			);
		}

		parent::__construct( CEMSSubscriberList::init(), __( 'CEMS Subscriber List', WPCEMS_TEXTDOMAIN ), $tabs );
	}

	/**
	 * Return a singleton instance of CEMSPluginPreferencesViewController class
	 *
	 * @brief Singleton
	 *
	 * @return CEMSPluginPreferencesViewController
	 */
	public static function init() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Override display_toolbar to remove toolbar
	 */
	public function display_toolbar() {
		
	}

	/**
	 * This static method is called when the head of this view controller is loaded by WordPress.
	 * It is used by WPDKMenu for example, as 'admin_head-' action.
	 *
	 * @brief Head
	 */
	public function admin_head() {
		// Enqueue pre-register WPDK components
		//WPDKUIComponents::init()->enqueue(WPDKUIComponents::CONTROLS, WPDKUIComponents::TOOLTIP);

		wp_enqueue_style( 'bootstrap', WPCEMS_URL_ASSETS . 'bootstrap3/css/bootstrap3.css', array(), '3.3.2' );
		wp_enqueue_style( 'bootstrap-theme', WPCEMS_URL_ASSETS . 'bootstrap3/css/bootstrap-theme3.css', array(), '3.3.2' );
		wp_enqueue_style( 'wpcems-subscriber-list', WPCEMS_URL_CSS . 'subscriber-list.css', array(), WPCEMS_VERSION );
		//
		wp_enqueue_script( 'bootstrap', WPCEMS_URL_ASSETS . 'bootstrap3/js/bootstrap3.js', array( 'jquery' ), '3.3.2', true );
		wp_enqueue_script( 'wpcems-subscriber-list', WPCEMS_URL_JAVASCRIPT . 'subscriber-list.js', array( 'jquery' ), WPCEMS_VERSION, true );
	}

}

/* * * */

/**
 * @class           CEMSSubscriberTableView
 * @author             Viet Trinh <quocviet@ssf.vn>
 * @date               2015-02-25
 * @version            1.0.1
 *
 */
class CEMSSubscriberTableView extends WPDKUITableView {

	private $_model;

	public function __construct( $model = null ) {
		parent::__construct( 'subscriber-table' );

		// Save the model
		$this->_model = $model;
	}

	/**
	 * Override function draw, edit table show
	 */
	public function draw() {
		// Sharing column attributes
		$this->column_atts = $this->column_atts();

		// Check for scrollable
		$style = empty( $this->scrollable_height ) ? '' : 'style="overflow-y:auto;height:' . $this->scrollable_height . '"';
		?>
		<table width="100%" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<?php foreach ( $this->columns() as $column_key => $label ) : ?>
						<th <?php echo $this->get_atts( $column_key ) ?> class="<?php echo $column_key ?>"><?php echo $label ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>

			<tbody>
				<?php foreach ( $this->items() as $item ) : ?>
					<?php $this->single_row( $item ) ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php
	}

	public function columns() {
		$columns = array(
			'subscriber-id' => __( 'List ID' ),
			'subscriber-name' => __( 'Name' ),
			'subscriber-shortcode' => __( 'Shortcode' ),
			'subscriber-action' => __( 'Action' )
		);

		return $columns;
	}

	public function items() {
		$items = array();
		global $wpdb;

		//frist step select all cems form
		$table_name = CEMSDatabase::get_table_subscribers_name();
		$results = $wpdb->get_results( "SELECT list_id, list_name FROM {$table_name} ORDER BY list_id DESC", ARRAY_A );

		// Run loop to attach to items array
		// Process your model to generate the rows
		foreach ( $results as $idx => $result_item ) {
			$items[] = array( 'subscriber-id' => $result_item['list_id'],
				'subscriber-name' => $result_item['list_name'],
				'subscriber-shortcode' => "[cems_subscriber_list list_id=\"{$result_item['list_id']}\"]",
				'subscriber-action' => '<form action="#" method="post"><input type="hidden" name="list_id" value="' . $result_item['list_id'] . '"/><input type="submit" name="action" value="Edit" class="cems-btn-edit button button-primary"/>&nbsp;<input type="submit" name="action" value="Delete" class="cems-btn-delete button button-primary"></form>'
			);
		}

		return $items;
	}

	/**
	 * @param $model
	 * @return CEMSSubscriberTableView
	 */
	public function init( $model ) {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self( $model );
		}

		return $instance;
	}

	public function column( $item, $column_key ) {
		switch ( $column_key ) {
			case 'subscriber-id':
			case 'subscriber-name':
			case 'subscriber-shortcode':
			case 'subscriber-action':
				return $item[$column_key];
		}
	}

}

/* * * */

/**
 * @class           CEMSCreateSubscriberView
 * @author             Viet Trinh <quocviet@ssf.vn>
 * @copyright          Copyright (C) 2015 Silicon Straits Saigon. All Rights Reserved.
 * @date               2015-02-25
 * @version            1.0.0
 *
 */
class CEMSCreateSubscriberView extends WPDKPreferencesView {

	/**
	 * Create an instance of CEMSCreateSubscribeFormView class
	 *
	 * @brief Construct
	 *
	 * @return CEMSCreateSubscribeFormView
	 */
	public function __construct() {
		$preferences = CEMSSubscriberList::init();

		parent::__construct( $preferences, 'create_subscriber_form' );
	}

	/**
	 * Return a sdf array for form fields
	 *
	 * @brief Return array for form fields
	 *
	 * @param CEMSPreferencesCreateSubscribeFormBranch $create_form
	 *
	 * @return array
	 */
	public function fields( $create_subscriber_form ) {
		
		$fields = array(
			__( 'Create new subscriber form', WPCEMS_TEXTDOMAIN ) => array(
				array(
					array(
						'type' => WPDKUIControlType::NUMBER,
						'name' => CEMSCreateSubscriberFormBranch::LIST_ID,
						'label' => __( 'List ID', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Input list id', WPCEMS_TEXTDOMAIN ),
						'required' => 'required',
						'attrs' => array( 'style' => 'text-align:left;' )
					)
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXT,
						'name' => CEMSCreateSubscriberFormBranch::LIST_NAME,
						'label' => __( 'List Name', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Input name', WPCEMS_TEXTDOMAIN ),
						'required' => 'required'
					)
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXTAREA,
						'name' => CEMSCreateSubscriberFormBranch::HTML_CODE,
						'id' => CEMSCreateSubscriberFormBranch::HTML_CODE,
						'label' => __( 'HTML Code', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'HTML Code', WPCEMS_TEXTDOMAIN ),
						'rows' => 20,
						'attrs' => array( 'required' => 'required' ),
					),
					
				),
				array(
					array(
						'type' => WPDKUIControlType::BUTTON,
						'id' => 'check_new_html_code',
						'value' => 'Check HTML code',
						'attrs' => array('class'=>'button button-primary')
					),
					array(
						'type' => WPDKUIControlType::BUTTON,
						'id' => 'convert_new_bootstrap',
						'value' => 'Convert to bootstrap3',
						'attrs' => array('class'=>'button button-primary','style' => 'margin-left:15px;')
					),
					array(
						'type' => WPDKUIControlType::CUSTOM,
						'content' => '<p id="check_new_html_code_text"></p>'
					),
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXTAREA,
						'name' => CEMSCreateSubscriberFormBranch::CUSTOM_CSS,
						'label' => __( 'Custom CSS', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Custom CSS', WPCEMS_TEXTDOMAIN ),
						'rows' => 12,
					)
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXTAREA,
						'name' => CEMSCreateSubscriberFormBranch::CUSTOM_SCRIPT,
						'label' => __( 'Custom Script', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Custom Script', WPCEMS_TEXTDOMAIN ),
						'rows' => 12,
					)
				),
			),
		);

		$list_custom_msg = CEMSDatabase::get_list_custom_msg_key();
		foreach ( $list_custom_msg as $key => $value ) {
			$fields[__( 'Create new subscriber form', WPCEMS_TEXTDOMAIN )][] = array(
				array(
					'type' => WPDKUIControlType::TEXT,
					'name' => $key,
					'label' => __( $value, WPCEMS_TEXTDOMAIN ),
					'placeholder' => __( $value, WPCEMS_TEXTDOMAIN ),
				),
			);
		}

		return $fields;
	}

}

/**
 * @class           CEMSEditSubscriberView
 * @author             Viet Trinh <quocviet@ssf.vn>
 * @copyright          Copyright (C) 2015 Silicon Straits Saigon. All Rights Reserved.
 * @date               2015-03-18
 * @version            1.0.0
 *
 */
class CEMSEditSubscriberView extends WPDKPreferencesView {

	/**
	 * Create an instance of CEMSCreateSubscribeFormView class
	 *
	 * @brief Construct
	 *
	 * @return CEMSCreateSubscribeFormView
	 */
	public function __construct() {
		$preferences = CEMSSubscriberList::init();
		parent::__construct( $preferences, 'edit_subscriber_form' );
	}

	/**
	 * Return a sdf array for form fields
	 *
	 * @brief Return array for form fields
	 *
	 * @param CEMSPreferencesCreateSubscribeFormBranch $create_form
	 *
	 * @return array
	 */
	public function fields( $edit_subscriber_form ) {

		global $wpdb;
		$sqlStr = "SELECT * FROM " . CEMSDatabase::get_table_subscribers_name() . " WHERE list_id = " . $_POST['list_id'] . " LIMIT 0,1";
		$subscriber_form_data = $wpdb->get_results( $sqlStr, ARRAY_A );



		$fields = array(
			__( 'Edit subscriber form', WPCEMS_TEXTDOMAIN ) => array(
				array(
					array(
						'type' => WPDKUIControlType::NUMBER,
						'name' => CEMSEditSubscriberFormBranch::LIST_ID,
						'label' => __( 'List ID', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Input list id', WPCEMS_TEXTDOMAIN ),
						'required' => 'required',
						'value' => $subscriber_form_data[0]['list_id'],
						'attrs' => array( 'style' => 'text-align:left;' )
					),
					array(
						'type' => WPDKUIControlType::HIDDEN,
						'name' => 'old_' . CEMSEditSubscriberFormBranch::LIST_ID,
						'value' => $subscriber_form_data[0]['list_id'],
					)
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXT,
						'name' => CEMSEditSubscriberFormBranch::LIST_NAME,
						'label' => __( 'List Name', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Input name', WPCEMS_TEXTDOMAIN ),
						'value' => $subscriber_form_data[0]['list_name'],
						'required' => 'required'
					)
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXTAREA,
						'name' => CEMSEditSubscriberFormBranch::HTML_CODE,
						'id' => CEMSEditSubscriberFormBranch::HTML_CODE,
						'label' => __( 'HTML Code', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'HTML Code', WPCEMS_TEXTDOMAIN ),
						'rows' => 20,
						'value' => stripslashes_deep( ( esc_js( $subscriber_form_data[0]['html_code'] ) ) ),
						'attrs' => array( 'required' => 'required' ),
					),
				),
				array(
					array(
						'type' => WPDKUIControlType::BUTTON,
						'id' => 'check_edit_html_code',
						'value' => 'Check HTML code',
						'attrs' => array('class'=>'button button-primary')
					),
					array(
						'type' => WPDKUIControlType::BUTTON,
						'id' => 'convert_edit_bootstrap',
						'value' => 'Convert to bootstrap3',
						'attrs' => array('class'=>'button button-primary','style' => 'margin-left:15px;')
					),
					array(
						'type' => WPDKUIControlType::CUSTOM,
						'content' => '<p id="check_edit_html_code_text"></p>'
					),
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXTAREA,
						'name' => CEMSEditSubscriberFormBranch::CUSTOM_CSS,
						'label' => __( 'Custom CSS', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Custom CSS', WPCEMS_TEXTDOMAIN ),
						'value' => stripslashes_deep( unserialize( base64_decode( $subscriber_form_data[0]['custom_css'] ) ) ),
						'rows' => 12,
					)
				),
				array(
					array(
						'type' => WPDKUIControlType::TEXTAREA,
						'name' => CEMSEditSubscriberFormBranch::CUSTOM_SCRIPT,
						'label' => __( 'Custom Script', WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( 'Custom Script', WPCEMS_TEXTDOMAIN ),
						'value' => stripslashes_deep( unserialize( base64_decode( $subscriber_form_data[0]['custom_script'] ) ) ),
						'rows' => 12,
					)
				),
			),
		);

		/*
		 * Select all custom msg
		 */
		$sqlStr = "SELECT `custom_key`,`custom_msg` FROM " . CEMSDatabase::get_table_custom_msg_name() . " WHERE list_id = " . $_POST['list_id'];
		$arr_custom_msg = $wpdb->get_results( $sqlStr, ARRAY_N );

		/* Get list custom msg key */
		$list_custom_msg = CEMSDatabase::get_list_custom_msg_key();
		foreach ( $list_custom_msg as $key => $value ) {
			$text = null;

			/* run loop to set text */
			for ( $i = 0; $i < count( $arr_custom_msg ); $i++ ) {
				if ( $arr_custom_msg[$i]['0'] == $key ) {
					$text = wp_unslash($arr_custom_msg[$i]['1']); /* set text */
					$list_custom_msg = array_slice( $list_custom_msg, $i ); /* remove item in index out of item */
					break;
				}
			}
			
			/* set value="" text if not null */
			if ( $text != null && strlen( $text . '' ) > 0 ) {
				$fields[__( 'Edit subscriber form', WPCEMS_TEXTDOMAIN )][] = array(
					array(
						'type' => WPDKUIControlType::TEXT,
						'name' => $key,
						'label' => __( $value, WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( $value, WPCEMS_TEXTDOMAIN ),
						'value' => $text,
					),
				);
			} else {
				$fields[__( 'Edit subscriber form', WPCEMS_TEXTDOMAIN )][] = array(
					array(
						'type' => WPDKUIControlType::TEXT,
						'name' => $key,
						'label' => __( $value, WPCEMS_TEXTDOMAIN ),
						'placeholder' => __( $value, WPCEMS_TEXTDOMAIN ),
					),
				);
			}
		}

		return $fields;
	}

}
