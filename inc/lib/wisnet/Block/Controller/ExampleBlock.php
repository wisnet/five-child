<?php
/**
 * File: ExampleBlock.php
 * Date: 2019-01-02
 * Time: 09:47
 *
 * @package wisnet Five
 * @author Michael Dahlke <mdahlke@wisnet.com>
 */

namespace wisnet\Block\Controller;

/**
 * Class ExampleBlock
 * @package wisnet\Block\Controller
 */
class ExampleBlock extends Base {
	protected $name = 'example-block';
	protected $title = 'Example Block';
	protected $description = 'A generic block that acts as a catch-all for blocks that do not need any special processing.';
	protected $category = 'formatting';
	protected $icon = 'editor-bold';
	protected $keywords = ['block'];

	public function __construct() {
		parent::__construct();
	}
}
