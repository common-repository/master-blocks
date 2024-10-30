<?php
/*
 * Template Name: Master Blocks
 * Description: A Page Template for Master Blocks plugin
 */

get_header();

echo '<main id="main" class="site-main" role="main">';

while ( have_posts() ) {
	the_post();
	the_content();
}

echo '</main>';

get_footer();
