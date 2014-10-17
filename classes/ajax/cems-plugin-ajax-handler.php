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
                'register_new_event_action' => true
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
            $first_name= sanitize_text_field($_POST['customerFName']);
          	$last_name= sanitize_text_field($_POST['customerLName']);
            //specific guessing based on the fact that the current TGMBooks using numeric value
            $province = sanitize_text_field($_POST['customerProvince']);
            //create customer
            try {
                $customer=$this->callCEMSApi('POST',
                    '/admin/customers.json',
                    array(
                        'email' => $customer_email,
                        'first_name' => $first_name,
                      	'last_name' => $last_name,
                        'phone'=>$phone,
                        'city'=>$province,
                      	'like_books' => 'Thích'
                    )
                )->getObject('CEMS\Customer');
            }
            catch(CEMS\BaseException $e)
            {
                if (strpos((string)$e,'email')==FALSE)
                {
                    $response->error='Lỗi khi đăng ký: '.$e->getFormattedMessage();
                    $response->json();
                }
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
                    $response->error = 'Lỗi khi đăng ký: '.$e->getFormattedMessage();
                    $response->json();
                }
                if (isset($customer))
                    try {
                        $update_customer=$this->callCEMSApi('PUT',
                            '/admin/customers/'.$customer->id.'.json',
                            array(
			'first_name' => $first_name,
			'last_name' => $last_name,
                                'phone'=>$phone,
                        'city'=>$province,
                        'like_books' => 'Thích'
                            )
                        )->getObject('CEMS\Customer');
                    }
                    catch (CEMS\BaseException $e)
                    {
                        $response->error = 'Không cập nhật thông tin được:'.$e;
                        $response->json();
                    }
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
                $response->error = CEMSPluginPreferences::init()->error_messages->invalid_data;
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
                $response->error=CEMSPluginPreferences::init()->error_messages->email_not_found;
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
                    $response->error='[ErrorCodeSG]'.CEMSPluginPreferences::init()->error_messages->subscription_unknown;
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
                    $response->error='[ErrorCodeSC]'.CEMSPluginPreferences::init()->error_messages->subscription_unknown;
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
                    $response->error=CEMSPluginPreferences::init()->error_messages->list_not_found;
                    $response->json();
                }
            }
            //TODO: return Ebook Link;
            //change data for link here
            $response->message='
                <div class="text-center">Cảm ơn bạn! Bạn có thể tải "<span class="book-title-result">'.$list->title.'</span>" tại đường dẫn dưới đây</div>';
            $list=$list->getObject('CEMS\Resource');
            if (isset($list->download_link))
            {
                $link=$list->download_link;
                ob_start();
                ?>
                <div class="text-center">
                    <h3><a href="<?php echo $link;?>"><span class="label label-primary">Tải về</span></a></h3>
                    <?php echo CEMSPluginPreferences::init()->error_messages->book_success_more;?>
                </div>
                <?php
                $response->data=ob_get_clean();
            }
            else
                $response->data=CEMSPluginPreferences::init()->error_messages->link_not_found;
            $response->json();
        }

        /**
         * Handler for registering new customer
         *
         * @brief Brief
         *
         * @return string
         */
        public function register_new_event_action()
        {
            // Prepare response
            $response = new WPDKAjaxResponse();

            if ( !isset( $_POST['eventId'] ) || empty( $_POST['customerEmail']) || intval($_POST['eventId'])<=0 ) {
                $response->error = __( 'Invalid Data. Please contact your administrator.', WPCEMS_TEXTDOMAIN );
                $response->json();
            }
            $listId = intval($_POST['listId']);
            $customer_email = sanitize_email($_POST['customerEmail']);
            $phone = sanitize_text_field($_POST['customerPhone']);
            $first_name= sanitize_text_field($_POST['customerFName']);
            $last_name= sanitize_text_field($_POST['customerLName']);
            //specific guessing based on the fact that the current TGMBooks using numeric value
            $province = sanitize_text_field($_POST['customerProvince']);
            //create customer
            try {
                $customer=$this->callCEMSApi('POST',
                    '/admin/customers.json',
                    array(
                        'email' => $customer_email,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'phone'=>$phone,
                        'city'=>$province,
                        'like_books' => 'Thích'
                    )
                )->getObject('CEMS\Customer');
            }
            catch(CEMS\BaseException $e)
            {
                if (strpos((string)$e,'email')==FALSE)
                {
                    $response->error='Lỗi khi đăng ký: '.$e->getFormattedMessage();
                    $response->json();
                }
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
                    $response->error = 'Lỗi khi đăng ký: '.$e->getFormattedMessage();
                    $response->json();
                }
                if (isset($customer))
                    try {
                        $update_customer=$this->callCEMSApi('PUT',
                            '/admin/customers/'.$customer->id.'.json',
                            array(
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'phone'=>$phone,
                                'city'=>$province,
                                'like_books' => 'Thích'
                            )
                        )->getObject('CEMS\Customer');
                    }
                    catch (CEMS\BaseException $e)
                    {
                        $response->error = 'Không cập nhật thông tin được:'.$e;
                        $response->json();
                    }
            }
            if (isset($customer))
                $this->getBook($response,$customer,$listId);
        }
    }
}