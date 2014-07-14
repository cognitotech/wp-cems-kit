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
         * @brief Allow ajax action
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

            if ( !isset( $_POST['listId'] ) || empty( $_POST['customerEmail']) || intval($_POST['listId'])<=0 ) {
                $response->error = __( 'Invalid Data. Please contact your administrator.', WPCEMS_TEXTDOMAIN );
                $response->json();
            }
            $listId = intval($_POST['listId']);
            $customer_email = sanitize_email($_POST['customerEmail']);
            $phone = sanitize_text_field($_POST['customerPhone']);
            $full_name= sanitize_text_field($_POST['customerName']);
            //specific guessing based on the fact that the current TGMBooks using numeric value
            $province = intval($_POST['customerProvince']);
            $reading=array_map('intval',$_POST['customerReading']);
            //create customer
            try {
                $customer=$this->callCEMSApi('POST',
                    '/admin/customers.json',
                    array(
                        'email' => $customer_email,
                        'full_name' => $full_name,
                        'phone'=>$phone,
                        'custom fields[province]'=>$province,
                        'custom fields[reading[]]'=>$reading,
                    )
                )->getObject('CEMS\Customer');
            }
            catch(CEMS\BaseException $e)
            {
                $response->error='Error when Create Customer: '.$e;
                $response->json();
            }
            if (isset($customer))
                $this->getBook($response,$customer,$listId);
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

            //Prepare data
            if ( !isset( $_POST['listId'] ) || empty( $_POST['subscriptionEmail']) || intval($_POST['listId'])<=0 ) {
                $response->error = __( 'Invalid Data. Please contact your administrator.', WPCEMS_TEXTDOMAIN );
                $response->json();
            }
            $listId = intval($_POST['listId']);
            $customer_email = sanitize_email($_POST['subscriptionEmail']);

            try {
                $customer=$this->callCEMSApi('GET',
                    '/admin/customers/find_by.json',
                    array(
                        'email'=>$customer_email
                    )
                )->getObject('CEMS\Customer');
            }
            catch(CEMS\BaseException $e)
            {
                $response->error='Customer: '.$e;
                $response->json();
            }
            if (isset($customer))
                $this->getBook($response,$customer,$listId);
        }

        /**
         * Helper function to call API
         *
         * @param $methodHttp
         * @param string $callback the api url, such as: '/admin/customers/find_by.json'
         * @param array $params key=>value pairs
         * @return \CEMS\Response
         * @throws CEMS\BaseException
         *
         */
        public function callCEMSApi($methodHttp, $callback='',$params=array())
        {
            $client=new \CEMS\Client(CEMSPluginPreferences::init()->general->api_token,CEMSPluginPreferences::init()->general->api_url);
            //Find something
            try{
                $res=$client->request($methodHttp,$callback,$params);
            }
            catch (CEMS\BaseException $e)
            {
                throw $e;
            }
            return $res;
        }

        /**
         * Helper Get Book Link and return to User
         * @param $response WPDKAJAXResponse Object
         * @param $customer Object as CEMS\Customer
         * @param $listId int
         */
        public function getBook($response=null,$customer=null,$listId=-1)
        {
            //check subscription registered yet?
            $subscription=null;
            try {
                $subscription = $this->callCEMSApi('GET',
                    '/admin/subscriptions/find_by.json',
                    array(
                        'customer_id'=>$customer->id,
                        'subscriber_list_id'=>$listId
                    )
                );
            }
            catch (CEMS\BaseException $e) {
                if ($e->getCode()!='404') //we find the not found status, if we got anything else, it means DOOM
                {
                    $response->error='Subscription: '.$e->getCode().' '.$e;
                    $response->json();
                }
            }

            if ($subscription==null)
            {
                //register a subscription for customer
                try{
                    $subscription=$this->callCEMSApi('POST',
                        '/admin/subscriptions.json',
                        array(
                            'customer_id'=>$customer->id,
                            'subscriber_list_id'=>$listId,
                            'status'=>'confirmed' // tell CEMS server not require user to confirm their emails
                        )
                    );
                }
                catch (CEMS\BaseException $e){
                    //cannot make new Subscription, kidding?
                    $response->error='Subscription Creation Error: '.$e;
                    $response->json();
                }
            }

            //now get the file for happy customer
            if ($subscription!=null)
            {
                try{
                    $list=$this->callCEMSApi('GET',
                        "/admin/subscriber_lists/$listId.json/"
                    );
                }
                catch (CEMS\BaseException $e){
                    //cannot fetch the List :(
                    $response->error='Book List Error: '.$e;
                    $response->json();
                }
            }
            //TODO: return Ebook Link;
            $response->message='Success!';
            //change data for link here
            $list=$list->getObject('CEMS\Resource');
            if (isset($list->download_link))
                $response->data='<a href="$list->download_link>">$list->download_link></a>';
            else
                $response->data='<a href="#">Intentionally Blanked link</a>';
            $response->json();
        }
    }
}