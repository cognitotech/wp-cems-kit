<?php

if ( wpdk_is_ajax() ) {

	class CEMSSubscriptionAjaxHandler extends WPDKAjax {

		/**
		 * Create or return a singleton instance of CEMSPluginAjaxHandler
		 *
		 * @brief Create or return a singleton instance of CEMSPluginAjaxHandler
		 *
		 * @return CEMSSubscriptionAjaxHandler
		 */
		public static function getInstance() {
			$instance = null;
			if ( is_null( $instance ) ) {
				$instance = new CEMSSubscriptionAjaxHandler();
			}
			return $instance;
		}

		/**
		 * Alias of getInstance();
		 *
		 * @brief Init the ajax register
		 *
		 * @return CEMSSubscriptionAjaxHandler
		 */
		public static function init() {
			return self::getInstance();
		}

		/**
		 * Return the array with the list of ajax allowed methods
		 *
		 * @brief Allow ajax action
		 *
		 * @return array
		 */
		protected function actions() {
			$actionsMethods = array(
				'new_subscription_action' => true,
			);
			return $actionsMethods;
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
		public function callCEMSApi( $methodHttp, $callback = '', $params = array() ) {
			$client = new \CEMS\Client( CEMSPluginPreferences::init()->general->api_token, CEMSPluginPreferences::init()->general->api_url );
			//Find something
			try {
				$res = $client->request( $methodHttp, $callback, $params );
			} catch ( CEMS\BaseException $e ) {
				throw $e;
			}
			return $res;
		}

		/**
		 * Find customer and return customer info
		 *
		 * can't direct access, only call by other function
		 *
		 * @param null $response
		 * @param null $customer_attributes
		 * @return null|object
		 */
		protected function find_customer( &$response = null, $customer_attributes = null ) {
			/**
			 * find customer by email or phone
			 */
			$customer = null;

			if ( array_key_exists( 'email', $customer_attributes ) ) {
				// find by email //
				try {
					$customer = $this->callCEMSApi( 'GET', '/admin/customers/find_by.json', array( 'email' => $customer_attributes['email'] )
							)->getObject( 'CEMS\Customer' );
				} catch ( CEMS\BaseException $e ) {
					$customer = null;
					$response->error = 'Can\'t register, check error: ' . $e->getFormattedMessage();
					$response->json();
				}
			} else if ( array_key_exists( 'phone', $customer_attributes ) ) {
				// find by phone //
				try {
					$customer = $this->callCEMSApi( 'GET', '/admin/customers/find_by.json', array( 'phone' => $customer_attributes['phone'] )
							)->getObject( 'CEMS\Customer' );
				} catch ( CEMS\BaseException $e ) {
					$customer = null;
					$response->error = 'Can\'t register, check error: ' . $e->getFormattedMessage();
					$response->json();
				}
			}

			return $customer;
		}

		/**
		 * Register new customer and return customer info
		 *
		 * can't direct access, only call by other function
		 *
		 * @param null $response
		 * @param null $customer_attributes
		 * @return null|object
		 */
		protected function register_new_customer( &$response = null, $customer_attributes = null ) {
			/** $customer default is null
			 * 1. try register new customer
			 * 2. error -> try find_by email & phone
			 * 3. return $customer
			 */
			$customer = null;

			// try send request to create customer & get customer info
			// if error -> customer is exists -> get customer info
			try {
				$customer = $this->callCEMSApi( 'POST', '/admin/customers.json', $customer_attributes )->getObject( 'CEMS\Customer' );
			} catch ( CEMS\BaseException $e ) {
				// error -> customer is exists -> get customer info by email or phone
				$customer = $this->find_customer( $response, $customer_attributes );
			}

			//return customer
			return $customer;
		}

		/**
		 * update customer and return customer info
		 *
		 * can't direct access, only call by other function
		 *
		 * @param null $response
		 * @param null $customer_attributes
		 * @param $customer_id
		 * @return null|object
		 */
		protected function update_customer( &$response = null, $customer_attributes = null, $customer_id ) {
			// update customer
			$customer = null;

			try {
				$customer = $this->callCEMSApi( 'PUT', '/admin/customers/' . $customer_id . '.json', $customer_attributes )->getObject( 'CEMS\Customer' );
				$flag = true;
			} catch ( CEMS\BaseException $e ) {
				$customer = null;
				$response->error = 'Can\'t update information, check error:' . $e;
				$response->json();
			}

			return $customer;
		}

		/**
		 * subscribe a list for customer
		 *
		 * can't direct access, only call by other function
		 *
		 * @param null $response
		 * @param int $listId : subscriber list id
		 * @param int $customer_id : customer id
		 */
		protected function subscribe_a_list( &$response = null, $listId = -1, $customer_id = -1 ) {
			$subscription = null;

			try {
				$subscription = $this->callCEMSApi( 'POST', '/admin/subscriptions.json', array(
					'customer_id' => $customer_id,
					'subscriber_list_id' => $listId,
					'status' => 'confirmed' // tell CEMS server not require user to confirm their emails
						)
				);
			} catch ( CEMS\BaseException $e ) {
				//cannot make new Subscription, kidding?
				$subscription = null;
				$response->error = '[ErrorCodeSC]' . CEMSPluginPreferences::init()->error_messages->subscription_unknown;
				$response->json();
			}

			return $subscription;
		}

		/**
		 * ALL HANDLER FUNCTION START
		 * */

		/**
		 * Handler for new subscription
		 *
		 * @return string
		 */
		public function new_subscription_action() {
			/**
			 * 1. Check [list_id] is exists -> not exists -> return request error
			 * 2. create new customer and get info
			 * 3. update customer info
			 * 4. subscription for customer
			 * */
			// Prepare response
			$response = new WPDKAjaxResponse();

			// check isset list_id
			if ( !isset( $_POST['list_id'] ) || intval( $_POST['list_id'] ) <= 0 ) {
				$response->error = __( 'Invalid Data. Please contact to administrator.', WPCEMS_TEXTDOMAIN );
				$response->json();
			} else {
				$listId = intval( $_POST['list_id'] );
				$customer = $this->register_new_customer( $response, $_POST['subscription']['customer_attributes'] );

				// check customer is exists & not null
				// do update customer and subscription
				if ( isset( $customer ) && $customer != null ) {
					//update_customer info
					$this->update_customer( $response, $_POST['subscription']['customer_attributes'], $customer->id );

					//register a subscription for customer
					$this->subscribe_a_list( $response, $listId, $customer->id );

					//set message if success
					if ( strlen( trim( $response->error . "" ) ) < 0 ){
						$response->message = "Subscription successful!.";
					}
				}
			}
		}

	}

}