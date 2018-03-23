<?php
/*
Plugin Name: Bro Excerpt Require
Plugin URI: https://alkoweb.ru
Author: petrozavodsky
Author URI: https://alkoweb.ru
Version: 1.0.0
*/

function bro_excerpt_require_update_post( $ID, $post ) {

	if ( empty( wp_strip_all_tags( $post->post_excerpt, true ) ) ) {


		$post_types = apply_filters( 'bro_excerpt_require_update_post__post_types', [ 'post' ] );

		$statuses = apply_filters( 'bro_excerpt_require_update_post__allow_statuses', [ 'pending', 'pending', 'auto-draft' ] );

		if ( in_array( $post->post_type, $post_types ) ) {

			if ( ! in_array( $post->post_status, $statuses ) ) {
				remove_action( 'save_post', 'bro_excerpt_require_update_post' );


				wp_update_post( [ 'ID' => $ID, 'post_status' => 'draft' ] );

				add_filter( 'redirect_post_location', function ( $location ) {
					return add_query_arg( [ 'empty_excerpt' => 'ID' ], $location );
				}, 99 );

				add_action( 'save_post', 'bro_excerpt_require_update_post' );
			}

		}

	}

}

add_action( 'save_post', 'bro_excerpt_require_update_post', 10, 2 );

function bro_excerpt_require_admin_notices() {
	if ( ! isset( $_GET[ 'empty_excerpt' ] ) ) {
		return;
	}

	$message = "Без отрывка запись может быть сохранена в качестве черновика";


	echo '<div id="notice" class="notice notice-warning is-dismissible"> <p>' . $message . '</p>';
	echo '<button class="notice-dismiss" type="button">';
	echo '<span class="screen-reader-text">' . $message . '</span>';
	echo '</button>';
	echo '</div>';
}

add_action( 'admin_notices', 'bro_excerpt_require_admin_notices' );