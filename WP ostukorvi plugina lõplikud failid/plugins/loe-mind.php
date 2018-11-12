<!-- Toote juures linkide kuvamiseks -->

<?php
	$toote_nimi = get_post_custom();
	echo do_shortcode('[ostukorv hind="'.$toote_nimi['hind'][0].'"]');
?>

