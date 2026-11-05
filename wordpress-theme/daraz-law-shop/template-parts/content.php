<?php
/** Journal card. @package Daraz_Law_Shop */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'journal-card' ); ?>>
<a class="journal-card-image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); else : ?><span class="journal-image-fallback">DARAZ <small>THE JOURNAL</small></span><?php endif; ?>
</a>
<div class="journal-card-copy"><?php daraz_post_meta(); ?><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read story', 'daraz-law-shop' ); ?> ↗</a></div>
</article>
