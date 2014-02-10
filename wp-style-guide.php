<?php

/*
Plugin Name: WP Style Guide
Plugin URI: http://slushman.com/plugins/wp-style-guide
Description: Creates a style guide for designers and their clients.
Version: 0.1
Text Domain: wp-style-guide
Domain Path: /languages
Author: Slushman
Author URI: http://slushman.com
License: GPLv2

**************************************************************************

  Copyright (C) 2014 Slushman

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General License for more details.

  You should have received a copy of the GNU General License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

**************************************************************************

*/

if ( !class_exists( 'Slushman_WP_Style_Guide' ) ) { //Start Class

    class Slushman_WP_Style_Guide {
  
        public static $instance;

/**
 * Constructor
 */ 
        function __construct() {
    
            self::$instance = $this;

        } // End of __construct()

    } // End of Slushman_WP_Style_Guide class

} // End of class_exists check

?>