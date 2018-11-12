<?php get_header(); ?>

<div id="content-container">
<div id="contents">
<div id="left-content">

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="633" height="105" id="flash" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="allowFullScreen" value="false" />
<param name="movie" value="<?php bloginfo('stylesheet_directory'); ?>/Flash/flash_v.swf" />
<param name="menu" value="Flash/flash" />
<param name="quality" value="high" />
<param name="scale" value="exactfit" />
<param name="bgcolor" value="#ffffff" />	
<param name="wmode" value="transparent" />	
<embed src="<?php bloginfo('stylesheet_directory'); ?>/Flash/flash_v.swf" menu="false" quality="high" scale="exactfit" bgcolor="#ffffff" width="633" height="105" name="Flash/flash" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" />
</object>

	<?php while (have_posts()) : the_post(); ?>
	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div id="list-container">
		<div id="shop-list-item">
			<?php
				if ( has_post_thumbnail() )
				the_post_thumbnail( 'thumbnail' );
			?><h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
			<?php the_content('Vaata l&#228;hemalt &#187;'); ?>
			<div class="shop-price-list">
				<span style="color: #666;">Hind: </span><?php meta('hind'); ?> &#128;
			</div>
			<div class="shop-action-list">
				<a href="<?php the_permalink() ?>">Vaata l&#228;hemalt ja telli &#187;</a>
			</div>
			
			<div class="clear"></div>
		</div>
		</div>
	</div>
<?php endwhile; ?>
	<div class="navi">
		<?php wp_pagenavi(); ?>
	</div>

</div>

<?php get_sidebar('pood'); ?>

<?php get_footer(); ?>
