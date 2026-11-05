<?php
/** Search form. @package Daraz_Law_Shop */
?>
<form role="search" method="get" class="site-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<label for="site-search-input"><?php esc_html_e( 'Search', 'daraz-law-shop' ); ?></label>
<div class="search-row"><input id="site-search-input" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'What are you looking for?', 'daraz-law-shop' ); ?>"><button type="submit"><?php esc_html_e( 'Search', 'daraz-law-shop' ); ?></button></div>
</form>
