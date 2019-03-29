<?php
/**
 * File: Ajax.php
 * Date: 2018-12-28
 * Time: 13:20
 *
 * @package wisnet Five
 * @author Michael Dahlke <mdahlke@wisnet.com>
 */

namespace wisnet\Controller;

class AjaxChild extends \wisnet\Controller\Ajax {

	public static function test() {
		wp_send_json_success(['message' => 'hi']);
	}

}
