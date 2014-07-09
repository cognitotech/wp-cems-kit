<?php
if ( wpdk_is_ajax() ) {

    /**
     * My Ajax Class
     *
     * @class              CEMSPluginAjaxHandler
     * @author             pnghai <nguyenhai@siliconstraits.vn>
     * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
     * @date               2014-07-15
     * @version            1.0.0
     *
     */
    class CEMSPluginAjaxHandler extends WPDKAjax {

        /**
         * Create or return a singleton instance of CEMSPluginAjaxHandler
         *
         * @brief Create or return a singleton instance of CEMSPluginAjaxHandler
         *
         * @return CEMSPluginAjaxHandler
         */
        public static function getInstance()
        {
            $instance = null;
            if ( is_null( $instance ) ) {
                $instance = new CEMSPluginAjaxHandler();
            }
            return $instance;
        }

        /**
         * Alias of getInstance();
         *
         * @brief Init the ajax register
         *
         * @return CEMSPluginAjaxHandler
         */
        public static function init()
        {
            return self::getInstance();
        }

        /**
         * Return the array with the list of ajax allowed methods
         *
         * @breief Allow ajax action
         *
         * @return array
         */
        protected function actions()
        {
            $actionsMethods = array(
                'register_new_customer_action' => true,
                'get_book_for_already_customer_action' => true,
            );
            return $actionsMethods;
        }

        /**
         * Handler for registering new customer
         *
         * @brief Brief
         *
         * @return string
         */
        public function register_new_customer_action()
        {
            // Prepare response
            $response = new WPDKAjaxResponse();

            if ( !isset( $_POST['listId'] ) || empty( $_POST['subscriptionEmail'] || intval($_POST['listId'])<=0) ) {
                $response->error = __( 'Invalid Data. Please contact your administrator.', WPCEMS_TEXTDOMAIN );
                $response->json();
            }
            $listId = intval($_POST['listId']);
            $customer_email = $_POST['subscriptionEmail'];

            $client=new CEMS\Client(CEMSPluginPreferences::init()->general->api_token,CEMSPluginPreferences::init()->general->api_url);
            try{
                $res=$client->get('/admin/customers/find_by.json',
                    array(
                        'email'=>$customer_email
                    )
                );
            }
            catch (CEMS\Error $e)
            {
                $response->error='Bad Request: '.$e;
                $response->json();
            }
            //TODO: getRequestQuery if it can
            //TODO: support check data null in API
            $customer=$res->getObject('CEMS\Customer');
            //TODO: check Subscription da tao hay chua?
            //TODO: Alow tao nhieu subscription?
            try{
                $res=$client->post('/admin/subscriptions.json',
                    array(
                        'customer_id' => $customer->id,
                        'subscriber_list_id' => $listId,
                        'status' => 'confirmed' //preventing email confirmation
                        //TODO: check this status is 'confirmed' or 'confirm'?
                    )
                );
            }
            catch (CEMS\Error $e)
            {
                $response->error='Bad Things Happened: '.$e;
                $response->json();
            }
            //TODO: get ebook link tu List/Subscription?
            $response->message='Success!';
            $response->data=$res->getObject()->ebook_link;
            $response->json();
        }

        /**
         * Handler for checking customer and return their book link
         *
         * @brief Check customer
         *
         * @return Ebook link
         */
        public function get_book_for_already_customer_action()
        {
            // Prepare response
            $response = new WPDKAjaxResponse();

            //TODO: Check customer already?
            if ( !isset( $_POST['listId'] ) || empty( $_POST['subscriptionEmail'] || intval($_POST['listId'])<=0) ) {
                $response->error = __( 'Invalid Data. Please contact your administrator.', WPCEMS_TEXTDOMAIN );
                $response->json();
            }
            $listId = intval($_POST['listId']);
            $customer_email = $_POST['subscriptionEmail'];

            $client=new CEMS\Client(CEMSPluginPreferences::init()->general->api_token,CEMSPluginPreferences::init()->general->api_url);
            try{
                $res=$client->get('/admin/customers/find_by.json',
                    array(
                        'email'=>$customer_email
                    )
                );
            }
            catch (CEMS\Error $e)
            {
                $response->error='Bad Request: '.$e;
                $response->json();
            }
            if (isset($res->getObject('CEMS\Customer')->id))
            {
                $response->error=__('Customer Already Registered ', WPCEMS_TEXTDOMAIN );
                $response->json();
            }

            //TODO: Create New Customer
            //TODO: Create Subscription To List
            $customer=$res->getObject('CEMS\Customer');
            //TODO: check Subscription da tao hay chua?
            //TODO: Alow tao nhieu subscription?
            try{
                $res=$client->post('/admin/subscriptions.json',
                    array(
                        'customer_id' => $customer->id,
                        'subscriber_list_id' => $listId,
                        'status' => 'confirmed' //preventing email confirmation
                        //TODO: check this status is 'confirmed' or 'confirm'?
                    )
                );
            }
            catch (CEMS\Error $e)
            {
                $response->error='Bad Things Happened: '.$e;
                $response->json();
            }

            //TODO: return Ebook Link;
            $response->message='Success!';
            $response->data=$res->getObject()->ebook_link;
            $response->json();
        }
    }
}