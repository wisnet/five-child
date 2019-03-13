<?php
/**
 * File: ExampleBlock.php
 * Date: 2019-01-02
 * Time: 09:50
 *
 * @package wisnet Five
 * @author Michael Dahlke <mdahlke@wisnet.com>
 */

namespace wisnet\Child\Block\View;

use wisnet\Block\View\Base;

class ExampleBlock extends Base {
	public $content = '';

	public function __construct(array $acfBlock, array $fields = []) {
		parent::__construct($acfBlock, $fields);
	}

	/**
	 * @return string
	 */
	public function getContent(): string {
		return $this->content;
	}

	/**
	 * @param string $content
	 * @return ExampleBlock
	 */
	public function setContent(string $content): ExampleBlock {
		$this->content = $content;
		return $this;
	}

}
