<?php
/**
 * File: App.php
 * Date: 2019-01-07
 * Time: 08:11
 *
 * @package wisnet Five
 * @author Michael Dahlke <mdahlke@wisnet.com>
 */

namespace wisnet;

use Timber\Menu;
use Timber\Post;
use Timber\Site;
use Twig_Extension_StringLoader;
use Twig_SimpleFilter;
use wisnet\Controller\Ajax;

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class App extends Site {
	/** @var string App Version */
	const VERSION    = '0.0.1';
	/**
	 * acf/block_name => ClassName
	 *
	 * @var array
	 */
	const ACF_BLOCKS = [
		'acf/slideshow' => 'Slideshow',
		'acf/recent-posts' => 'RecentPosts',
		'acf/hours' => 'Hours',
		'acf/heading' => 'Heading',
		'acf/side-by-side' => 'SideBySide',
	];

	public function __construct() {
		parent::__construct();
		$this->register_autoload();
		$this->register_timber();
	}

	/** Add timber support. */
	public function register_timber() {
		add_action('after_setup_theme', [$this, 'theme_supports']);
		add_filter('timber/context', [$this, 'add_to_context']);
		add_filter('get_twig', [$this, 'add_to_twig']);
	}

	protected function register_autoload() {
		spl_autoload_register(function ($class) {
			$directories = ['Controller', 'Model', 'View', 'Setting', 'Blocks', 'Blocks\View', 'Block\Model', 'Block\Setting'];
			$parts = explode('\\', $class);

			if (in_array(strtolower($parts[0]), ['wisnet', 'flash'])) {
				foreach ($directories ?: [] as $dir) {
					$file = get_template_directory() . '/inc/lib/' . implode('/', $parts) . '.php';

					if (file_exists($file)) {
						include($file);
						return true;
					}
				}
			};
		});
	}

	public function frontend() {
		add_action('wp', [$this, 'enqueue_scripts']);
		add_action('wp', [$this, 'enqueue_styles']);
		add_action('init', [$this, 'register_menus']);

		$ajax = new Ajax();
		$ajax->register_ajax_routes();
	}

	public function backend() {
		add_action('init', [$this, 'register_menus']);
		add_theme_support('editor-styles');
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
		add_action('enqueue_block_assets', [$this, 'enqueue_block_editor_assets']);
	}

	public function enqueue_scripts() {
		//		wp_register_script('site-js', get_stylesheet_directory_uri() . '/dist/js/bundle.js', ['jquery'], self::VERSION, true);
		wp_register_script('site-js', get_stylesheet_directory_uri() . '/dist/js/app.js', ['jquery'], self::VERSION, true);
		wp_localize_script('site-js', 'wajax', [
			'url' => admin_url('admin-ajax.php'),
			//			'registeredAcfBlocks' => json_encode(self::ACF_BLOCKS),
		]);
		wp_enqueue_script('site-js');
		//		wp_add_inline_script('site-js', 'window.registeredAcfBlocks = ' . json_encode(self::ACF_BLOCKS), 'before');
	}

	public function admin_enqueue_scripts() {
		//		wp_register_script('site-js', get_stylesheet_directory_uri() . '/dist/js/bundle.js', ['jquery'], self::VERSION, true);
		wp_register_script('site-js', get_stylesheet_directory_uri() . '/dist/js/app.js', ['jquery', 'jquery-ui'], self::VERSION, true);
		wp_localize_script('site-js', 'wajax', [
			'url' => admin_url('admin-ajax.php'),
			//			'registeredAcfBlocks' => json_encode(self::ACF_BLOCKS),
		]);
		wp_enqueue_script('site-js');
	}

	public function enqueue_styles() {
		wp_register_style('site-css', get_stylesheet_directory_uri() . '/dist/css/main.css', [], self::VERSION, 'all');
		wp_enqueue_style('site-css');
	}

	public function enqueue_block_editor_assets() {
		wp_register_script('site-block-js', get_stylesheet_directory_uri() . '/dist/js/blocks.js', ['wp-blocks'], self::VERSION, true);
		wp_enqueue_script('site-block-js');
		wp_enqueue_style('site-gutenberg-css', get_stylesheet_directory_uri() . '/dist/css/gutenberg.css', ['wp-edit-blocks'], '1.0.0', 'all');
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 * @return string
	 */
	public function add_to_context($context) {
		$context['menu'] = new Menu('primary');
		$context['site'] = $this;
		$context['post'] = new Post();
		$context['options'] = get_fields('option');
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		add_theme_support('editor-styles');
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', [
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'post-thumbnail',
			]
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', [
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			]
		);

		add_theme_support('menus');
	}

	function register_menus() {
		register_nav_menus(
			[
				'new-menu' => __('Primary Navigation'),
				'another-menu' => __('Footer Navigation'),
			]
		);
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 * @return string
	 */
	public function add_to_twig($twig) {
		$twig->addExtension(new Twig_Extension_StringLoader());
		$twig->addFilter(new Twig_SimpleFilter('acf_image', [(new Controller\ACFImage()), 'getUrl']), []);
		$twig->addFilter(new Twig_SimpleFilter('a_phone', [(new Controller\Link()), 'aPhone']), []);
		$twig->addFilter(new Twig_SimpleFilter('a_email', [(new Controller\Link()), 'aEmail']), []);
		$twig->addFilter(new Twig_SimpleFilter('link_phone', [(new Controller\Link()), 'linkPhone']), []);
		$twig->addFilter(new Twig_SimpleFilter('link_email', [(new Controller\Link()), 'linkEmail']), []);
		$twig->addFilter(new Twig_SimpleFilter('d', 'd'), []);
		$twig->addFilter(new Twig_SimpleFilter('v', 'v'), []);
		$twig->addFilter(new Twig_SimpleFilter('p', 'p'), []);
		$twig->addFilter(new Twig_SimpleFilter('row', 'bs_row'), []);
		// allow twig templates to easily add default block layout settings
		$twig->addFilter(new Twig_SimpleFilter('block_layout_attributes', [(new Block\Controller\Base()), 'blockLayoutAttributes']), []);
		$twig->addFilter(new Twig_SimpleFilter('block_global_setting', [(new Block\Model\GlobalSetting()), 'getGlobalBlockSetting']), []);
		return $twig;
	}

}

