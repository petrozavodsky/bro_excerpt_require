<?php
/*
Plugin Name: Bro Excerpt Require
Plugin URI: https://alkoweb.ru
Author: petrozavodsky
Author URI: https://alkoweb.ru
Version: 1.0.0
*/

function bro_excerpt_require_update_post($data){

	return $data;
}


add_action( 'wp_insert_post_data', [ $this, 'update_post' ], 1, 1 );

