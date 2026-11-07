<?php
/**
 * Plugin Name: Web86 File Map
 * Description: Урок 2 — структура файлов Gutenberg-блока.
 * Version: 1.0.0
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * Author: Web86
 * Text Domain: web86-file-map
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
add_action( 'init', function () {
    register_block_type( __DIR__ . '/build' );
} );
