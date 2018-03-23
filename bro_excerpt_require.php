<?php
/*
Plugin Name: Bro Excerpt Require
Plugin URI: https://alkoweb.ru
Author: petrozavodsky
Author URI: https://alkoweb.ru
Version: 1.0.0
*/

function bro_excerpt_require_update_post( $data ) {

	if ( empty( wp_strip_all_tags( $data['post_excerpt'], true ) ) ) {


		$post_types = apply_filters('bro_excerpt_require_update_post__post_types', ['post']);

		$statuses = apply_filters('bro_excerpt_require_update_post__allow_statuses', [ 'pending', 'pending', 'auto-draft']);

		if( in_array($data['post_type'], $post_types)) {

			if ( ! in_array( $data['post_status'], $statuses ) ) {
				$data['post_status'] = 'draft';
			}

		}

	}

	return $data;
}


add_action( 'wp_insert_post_data', 'bro_excerpt_require_update_post', 1, 1 );

