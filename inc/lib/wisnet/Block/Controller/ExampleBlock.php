<?php
/**
 * File: Heading.php
 * Date: 2019-01-02
 * Time: 09:47
 *
 * @package wisnet Five
 * @author Michael Dahlke <mdahlke@wisnet.com>
 */

namespace wisnet\Child\Block\Controller;

use wisnet\Block\Controller\Base;

class ExampleBlock extends Base {
	protected $name = 'butt';
	protected $title = 'Butt';
	protected $description = 'A generic block that acts as a catch-all for blocks that do not need any special processing.';
	protected $category = 'formatting';
	protected $icon = 'editor-bold';
	protected $keywords = ['block'];

	public function __construct() {
		add_action('acf/init', [$this, 'register']);
		parent::__construct();
	}
}
