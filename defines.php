<?php

/**
 * Constants
 *
 * @author             pnghai
 * @copyright          Copyright (C) 2013-2014 Silicon Straits. All Rights Reserved.
 * @date               2014-07-15
 * @version            1.0.0
 *
 */

/**
* @var CEMSPlugin $this
*/
define( 'WPCEMS_VERSION', $this->version );
define( 'WPCEMS_LOGO', $this->imagesURL . 'sss-logo-16x16.png');

define( 'WPCEMS_TEXTDOMAIN', $this->textDomain );
define( 'WPCEMS_TEXTDOMAIN_PATH', $this->textDomainPath );

define( 'WPCEMS_PATH', $this->path );
define( 'WPCEMS_PATH_CLASSES', $this->classesPath );
define( 'WPCEMS_PATH_CSS', $this->path . 'assets/css/' );

define( 'WPCEMS_URL_ASSETS', $this->assetsURL );
define( 'WPCEMS_URL_CSS', $this->cssURL );
define( 'WPCEMS_URL_JAVASCRIPT', $this->javascriptURL );
define( 'WPCEMS_URL_IMAGES', $this->imagesURL );