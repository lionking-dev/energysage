<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  mod_zipcode
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class ModZipcode {
    public static function display($params) {
        // You can write the code here to display the form for entering the zip code
        ob_start();
        include 'tmpl/default.php';
        $output = ob_get_clean();
        return $output;
    }
}