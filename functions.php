<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

//
///**
// * Path to Atomic docs
// */
//define('ATOMIC', 'src/components/');
//define('ATOMIC_ORGANISM', ATOMIC . 'organisms');
//define('ATOMIC_MOLECULE', ATOMIC . 'molecules');
//define('ATOMIC_ATOM', ATOMIC . 'atoms');
//define('ATOMIC_SIDEBARS', ATOMIC . 'sidebars');
//define('ATOMIC_SIDEBAR', ATOMIC_SIDEBARS);
//define('ATOMIC_LAYOUT', ATOMIC . 'layout');
//define('ATOMIC_BLOCKS', ATOMIC . 'blocks');

DEFINE('THEME_VERSION', (wp_get_theme()->version ?? null));

if (!class_exists('Timber')) {
	add_action('admin_notices', function () {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
	});

	add_filter('template_include', function ($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

/**
 * Register child scripts
 */
add_action('wisnet/enqueue_scripts', 'five_child_enqueue_styles', 999, 3);
function five_child_enqueue_styles($js, $css, $extra) {
	if ($css) {
		wp_register_style('child-style',
			get_stylesheet_directory_uri() . '/style.css',
			[$css],
			wp_get_theme()->get('Version')
		);
		wp_enqueue_style('child-style');
	}

	if ($js) {
		wp_register_script('child-js', get_stylesheet_directory_uri() . '/dist/js/app.js', [$js], 0.1, true);
		wp_localize_script('child-js', 'ajax', [
			'url' => admin_url('admin-ajax.php'),
		]);
		wp_enqueue_script('child-js');
	}
}

/**
 * Register child block editor scripts
 */
add_action('wisnet/enqueue_block_editor_assets', 'five_child_block_editor', 999, 3);
function five_child_block_editor($js, $css, $extra) {
	if ($js) {
		wp_register_script('child-block-js', get_stylesheet_directory_uri() . '/dist/js/blocks.js', [$js], THEME_VERSION, true);
		wp_enqueue_script('child-block-js');
	}
	if ($css) {
		wp_enqueue_style('child-gutenberg-css', get_stylesheet_directory_uri() . '/dist/css/gutenberg.css', [$css], THEME_VERSION, 'all');
	}
}

/**
 * Register new ACF blocks
 */
add_filter('wisnet/register_acf_blocks', function ($blocks) {
	$blocks['acf/example-block'] = 'ExampleBlock';

	return $blocks;
}, 999, 1);

/**
 * Add more ajax routes
 */
add_filter('wisnet/ajax_routes', function ($routes) {
	$routes['child_test'] = ['\wisnet\Controller\AjaxChild\test', 'test'];

	return $routes;
});

/**
 * Load the parent ACF fields
 */
add_filter('acf/settings/load_json', 'parent_theme_field_groups');
function parent_theme_field_groups($paths) {
	$path = get_template_directory() . '/acf-json';
	$paths[] = $path;
	return $paths;
}
