/**
* Plugin Name: Wordpress CEMS Kit
* Plugin URI: http://siliconstraits.com
* Description: Worpress CEMS Kit plugin with full WPDK support
* Version: 1.0.0
* Author: Hai Phan Nguyen
* Author URI: http://siliconstraits.com
*/
<?

require_once(  dirname( __FILE__ ) . '/wpdk-production/wpdk.php' );
require_once( dirname( __FILE__ ) . '/vendor/autoload.php');
// Define of include your main plugin class
if( !class_exists( 'CEMSPlugin' ) )
{

    /**
     * Class CEMSPlugin
     */
    class CEMSPlugin extends WPDKWordPressPlugin {

        /**
         * Create an instance of CEMSPlugin class
         */
        public function __construct( ) {

            parent::__construct( );
            $this->defines();
        }

        // Include you own defines
        private function defines()
        {
            include_once( 'defines.php' );
        }

        // Called when the plugin is activate - only first time
        public function activation()
        {
            // To override
        }

        // Called when the plugin is deactivated
        public function deactivation()
        {
            // To override
        }

        // Called when the plugin is loaded
        public function loaded()
        {
            // To override
        }

        // Called when the plugin is fully loaded
        public function preferences()
        {
            // To override
        }

        // Called only if the web request is related to the front-end side of WordPress
        public function theme()
        {
            // To override
        }

        // Called only if the web request is related to the admin side of WordPress
        public function admin()
        {
            // To override
        }

    }
}
$GLOBALS['CEMSPlugin'] = new CEMSPlugin();