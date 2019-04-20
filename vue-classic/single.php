<?php
/**
 * File: single.php
 *
 * @package Vue_Classic
 */

get_header();

$post = array();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		$post_id = get_the_ID();

		if ( ! empty( get_the_post_thumbnail( $post_id, 'banner' ) ) ) {
			$thumbnail = array(
				'alt' => get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ),
				'url' => get_the_post_thumbnail_url( $post_id, 'banner' ),
			);
		}

		$author_id = get_the_author_ID();
		$author_name = get_the_author_firstname() . ' ' . get_the_author_lastname();

		if ( strlen( $author_name ) <= 1 ) {
			$author_name = get_the_author_nickname();
		}

		$post = array(
			'title'     => get_the_title(),
			'content'   => apply_filters( 'the_content', get_the_content() ),
			'thumbnail' => $thumbnail,
			'date'		=> get_the_date(),
			'author'	=> array(
				'name'	=> $author_name,
				'link'	=> get_author_posts_url( $author_id ),
			),
		);
	}
}

$post = wp_json_encode( $post );
?>

<div id="app" data-component="Post" data-props='<?php print_r( $post ); ?>'></div>

<?php get_footer(); ?>