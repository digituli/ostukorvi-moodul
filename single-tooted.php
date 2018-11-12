<?php while (have_posts()) : the_post(); ?>
	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div id="shop-single-item">
			<?php
				if ( has_post_thumbnail() )
				the_post_thumbnail( 'thumbnail' );
			?><h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<div class="shop-price">
				<span style="color: #666;">Hind: </span><?php meta('hind'); ?> &#128;
			</div>
			<div class="clear"></div>
		</div>
		<div id="shop-action">
			<?php
				$toote_nimi = get_post_custom();
				echo do_shortcode('[ostukorv nimi="'.str_replace('"', ' ', $toote_nimi['toode'][0]).'" hind="'.$toote_nimi['hind'][0].'"]');
			?>
		</div>
</div>

<?php endwhile; ?>