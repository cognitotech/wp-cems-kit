<?php

/**
 * @class              AboutViewController
 * @author             pnghai <nguyenhai@siliconstraits.vn>
 * @copyright          Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */
class AboutViewController extends WPDKViewController {

  /**
   * Create an instance of AboutViewController class
   *
   * @brief Construct
   *
   * @return AboutViewController
   */
  public function __construct()
  {
    // Build the container, with default header
    #TODO: custom header here if you can.
    parent::__construct( 'my-view-controller-5', 'About Wordpress CEMS Toolkit' );
  }

  /**
   * Override display
   *
   * @brief Brief
   */
  public function display()
  {

    // call parent display to build default page structure
    parent::display();

    // show custom content
    ?>
    <h3>Why we do this?</h3>
    <div>This is fun, and make your life easier.</div>
  <?php
  }

}
