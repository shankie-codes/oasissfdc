<?php

// Register style sheet.
add_action( 'wp_enqueue_scripts', 'register_pure' );
add_action( 'wp_enqueue_scripts', 'register_fontawesome' );

/**
 * Register style sheet.
 */
function register_pure() {
	wp_register_style( 'pure-forms', 'http://yui.yahooapis.com/pure/0.5.0/forms-min.css' );
	wp_enqueue_style( 'pure-forms' );
	wp_register_style( 'pure-buttons', 'http://yui.yahooapis.com/pure/0.5.0/buttons-min.css' );
	wp_enqueue_style( 'pure-buttons' );
}
function register_fontawesome() {
	wp_register_style( 'fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'fontawesome' );
}