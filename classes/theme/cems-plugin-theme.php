<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:30 PM
 */

/**
 * Front end for CEMS Toolkit
 *
 * @class           CEMSPluginTheme
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class CEMSPluginTheme extends WPDKWordPressTheme {

	/**
	 * Return a singleton instance of CEMSPluginTheme class
	 *
	 * @brief Singleton
	 *
	 * @return CEMSPluginTheme
	 */
	public static function init() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Create an instance of CEMSPluginTheme class
	 *
	 * @brief Construct
	 *
	 * @return CEMSPluginTheme
	 */
	public function __construct() {
		/**
		 * @var CEMSPlugin $plugin
		 */
		$plugin = $GLOBALS['CEMSPlugin'];
		parent::__construct( $plugin );
	}

	/**
	 * Called by `wp_enqueue_scripts` action. You will use this action to register (do a queue) scripts and styles.
	 *
	 * @brief WordPress action for scripts and styles
	 */
	public function wp_enqueue_scripts() {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', ("http://code.jquery.com/jquery-latest.min.js" ) );
		wp_enqueue_script( 'jquery' );

		/**
		* Enqueue for script
		*/
		wp_enqueue_script( 'wpcems-browser', '//cdnjs.cloudflare.com/ajax/libs/jquery-browser/0.0.6/jquery.browser.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wpcems-migrate', '//code.jquery.com/jquery-migrate-1.2.1.min.js', array( 'jquery' ), false, true );
		
		// Added styles and script for frontend
		WPDKUIComponents::init()->enqueue( array( WPDKUIComponents::MODAL, WPDKUIComponents::TOOLTIP ) );
		wp_enqueue_script( 'wpcems-variables', WPCEMS_URL_JAVASCRIPT . 'cems-variables.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wpcems-bootstrap', WPCEMS_URL_ASSETS . 'bootstrap3/js/bootstrap3.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wpcems-bootstrapvalidator', '//cdn.jsdelivr.net/jquery.bootstrapvalidator/0.4.5/js/bootstrapValidator.min.js', array( 'wpcems-bootstrap' ), false, true );
		wp_enqueue_script( 'wpcems-chosen', '//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wpcems-customer-source', '//cdn.cognitocrm.com/js/customer_source.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wpcems-subscription', WPCEMS_URL_JAVASCRIPT . 'cems-subscription.js', array( 'jquery' ), false, true );

		/**
		* Enqueue for css
		*/
		wp_enqueue_style( 'wpcems-bootstrap', WPCEMS_URL_ASSETS . 'bootstrap3/css/bootstrap3.css', array(), false );
		wp_enqueue_style( 'wpcems-bootstrap-theme', WPCEMS_URL_ASSETS . 'bootstrap3/css/bootstrap-theme3.css', array(), false );

		wp_enqueue_style( 'wpcems-theme', WPCEMS_URL_CSS . 'cems-theme.css', array(),false);
		wp_enqueue_style( 'wpcems-chosen', '//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css', array(), false );
		wp_enqueue_style( 'wpcems-bootstrap-chosen', WPCEMS_URL_CSS . 'bootstrap-chosen.min.css', array(), false );
		wp_enqueue_style( 'wpcems-bootstrapvalidator', '//cdn.jsdelivr.net/jquery.bootstrapvalidator/0.4.5/css/bootstrapValidator.min.css', array(), false );

		
	}

	/**
	 * Output the custom css style
	 *
	 * @brief CSS style
	 * @since 1.2.0
	 */
	public function wp_head() {
		//WPDKUIComponents::init()->enqueue( WPDKUIComponents::WPDK );

		WPDKHTML::startCompress();
		?>

		<?php //if ( wpdk_is_bool( CEMSPluginPreferences::init()->layout->css_style_enabled ) ) : ?>
			<!-- CEMS Custom CSS -->
			<!--<style type="text/css">-->
			<?php //echo CEMSPluginPreferences::init()->layout->css_style; ?>
			<!--</style>-->
			<script type='text/javascript'>
				/* <![CDATA[ */
				wpdk_i18n = {"ajaxURL": "<?php echo admin_url( 'admin-ajax.php' ); ?>", "messageUnLockField": "Please confirm before unlock this form field.\nDo you want unlock this form field?", "timeOnlyTitle": "Choose Time", "timeText": "Time", "hourText": "Hour", "minuteText": "Minute", "secondText": "Seconds", "currentText": "Now", "dayNamesMin": "Su,Mo,Tu,We,Th,Fr,Sa", "monthNames": "January,February,March,April,May,June,July,August,September,October,November,December", "monthNamesShort": "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec", "closeText": "Close", "dateFormat": "d M yy", "timeFormat": "HH:mm"};
				/* ]]> */
			</script>
		<?php //endif; ?>

		<?php
		echo WPDKHTML::endCSSCompress();
	}

}
