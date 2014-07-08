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

            // Your code...

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

            // Your code...

            $response->json();
        }
    }
}