<?php
/**
 * Plugin Name:       Web86 Hello
 * Description:       Первый учебный Gutenberg-блок Web86.
 * Version:           1.0.0
 * Requires at least: 6.3
 * Requires PHP:      7.4
 * Author:            Web86
 * Author URI:        https://web86.site/
 * Text Domain:       web86-hello
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', function () {
    register_block_type( __DIR__ . '/build' );
} );
