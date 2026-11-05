<?php
/** WordPress comments template. @package Daraz_Law_Shop */
if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area">
<?php if ( have_comments() ) : ?>
<h2><?php printf( esc_html( _n( '%d comment', '%d comments', get_comments_number(), 'daraz-law-shop' ) ), absint( get_comments_number() ) ); ?></h2>
<ol class="comment-list"><?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?></ol>
<?php the_comments_navigation(); ?>
<?php endif; ?>
<?php if ( ! comments_open() && get_comments_number() ) : ?><p><?php esc_html_e( 'Comments are closed.', 'daraz-law-shop' ); ?></p><?php endif; ?>
<?php comment_form(); ?>
</section>
