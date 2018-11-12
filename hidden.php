<?php
/*
Plugin Name: Contact Form 7 Modules: Hidden Fields
Plugin URI: http://www.seodenver.com/contact-form-7-hidden-fields/
Description: Add hidden fields to the popular Contact Form 7 plugin.
Author: Katz Web Services, Inc.
Author URI: http://www.katzwebservices.com
Version: 1.1.2
*/

/*  Copyright 2011 Katz Web Services, Inc. (email: info at katzwebservices.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
** A base module for [hidden] and [hidden*]
**/

/* Shortcode handler */

#if(function_exists('wpcf7_add_shortcode')) {

add_action('plugins_loaded', 'contact_form_7_hidden_fields', 10);

function contact_form_7_hidden_fields() {
	global $pagenow;
	if(function_exists('wpcf7_add_shortcode')) {
		wpcf7_add_shortcode( 'hidden', 'wpcf7_hidden_shortcode_handler', true );
		wpcf7_add_shortcode( 'hidden*', 'wpcf7_hidden_shortcode_handler', true );
	} else {
		if($pagenow != 'plugins.php') { return; }
		add_action('admin_notices', 'cfhiddenfieldserror');
		wp_enqueue_script('thickbox');
		function cfhiddenfieldserror() {
			$out = '<div class="error" id="messages"><p>';
			if(file_exists(WP_PLUGIN_DIR.'/contact-form-7/wp-contact-form-7.php')) {
				$out .= 'The Contact Form 7 is installed, but <strong>you must activate Contact Form 7</strong> below for the Hidden Fields Module to work.';
			} else {
				$out .= 'The Contact Form 7 plugin must be installed for the Hidden Fields Module to work. <a href="'.admin_url('plugin-install.php?tab=plugin-information&plugin=contact-form-7&from=plugins&TB_iframe=true&width=600&height=550').'" class="thickbox" title="Contact Form 7">Install Now.</a>';
			}
			$out .= '</p></div>';	
			echo $out;
		}
	}
}

function mArraytoText($aArray, $aKogused)
{
	$sOutput = '';
	if(is_array($aArray))
	{
		foreach($aArray as $ID => $sValue)
		{
			$sOutput .= $sValue.' ('.$aKogused[$ID].')</br>';
		}
		$sOutput = rtrim($sOutput, ', ');
	}
	return $sOutput;	
}

function mGetCurrentPageUrl()
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on")
	{
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

/** Martin Orgla */
function mGetWordpressBasedData ( $sField )
{
	global $wpdb;
	global $wp_query;
	
	$iPageID = $wp_query->get_queried_object_id();
	$oResult = $wpdb->get_row("SELECT * FROM " . $wpdb->posts . " WHERE ID = ".$iPageID."", ARRAY_A);

	return $oResult[$sField];
}

// [bartag foo="foo-value"]
function mShoppingCartLink( $atts ) {
	$aGet = $_GET;
	
	extract( shortcode_atts( array(
		// 'nimi'    => '',
		'hind'    => ''
	), $atts ) );
	

	if(strlen($aGet['lisa']) > 0)
	{
		$aSession = $_SESSION['tooted'];
		
		if(strlen(mGetWordpressBasedData('ID')) > 0)
		{
			$id = mGetWordpressBasedData('ID');
		}
		
		if(!is_array($aSession))
		{
			$_SESSION['tooted']  = array($id => mGetWordpressBasedData('post_title'));
			$_SESSION['kogused'] = array($id => '1');
			$_SESSION['hind']	 = array($id => $hind);
		}
		else
		{
			$_SESSION['tooted'][$id]  = mGetWordpressBasedData('post_title');
			$_SESSION['kogused'][$id] = '1';
			$_SESSION['hind'][$id]    = $hind;
		}
		
		echo '<div class="shopping_cart_msg">Toode on lisatud ostukorvi</div>';
	}
	
	if(strlen($hind) > 0)
	{
		$sOutput  = '<a href="'.mGetWordpressBasedData('guid').'&lisa='.mGetWordpressBasedData('ID').'">Lisa Ostukorvi</a> ';
		$sOutput .= '<a href="http://www.rannarahvamuuseum.ee/tellimuse-kinnitus/">Vaata ostukorvi</a>';
		return $sOutput;
	}

}
add_shortcode( 'ostukorv', 'mShoppingCartLink' );


/** Sidebaril ostukorv */
function mShoppingCartSidebar() {
	if(isset($_SESSION['tooted']))
	{
		if(count($_SESSION['tooted']) == 0)
		{
			$sOut = 'Ostukorv on tühi';
		}
		elseif(count($_SESSION['tooted']) == 1)
		{
			$sOut = 'Ostukorvis on 1 toode';
		}
		else
		{
			$sOut = 'Ostukorvis on ' . count($_SESSION['tooted']) . ' toodet';
		}	
	}
	else
	{
		$sOut = 'Ostukorv on tühi';
	}
	return '<div class="shopping_cart_sidebar">' . $sOut . '</div>';
}
add_shortcode( 'ostukorv-sidebaril', 'mShoppingCartSidebar' );

function mProductQuantity ( $atts = NULL )
{
	if(strlen($_GET['del_id']) > 0)
	{
		unset($_SESSION['tooted'][$_GET['del_id']]);
		unset($_SESSION['kogused'][$_GET['del_id']]);
		unset($_SESSION['hind'][$_GET['del_id']]);
		echo 'Kustutatud';
	}
	
	if(count($_POST['kogused']) > 0)
	{
		foreach($_POST['kogused'] as $ID => $sValue)
		{
			if($sValue > 0)
			{
				$_SESSION['kogused'][$ID] = $sValue;
			}
		}
		wp_redirect( mGetWordpressBasedData('guid'), '303' );
	}	

	if(count($_SESSION['tooted']) > 0)
	{		
		$html = '<form action="'.mGetWordpressBasedData('guid').'" method="post" name="uus_form"><b>Kogused:</b><br /><br />';
		foreach($_SESSION['tooted'] as $id => $sNimetus)
		{
			$html .= '<input type="text" style="width: 20px; " name="kogused['.$id.']" class="hidden_field_amount" value="'.$_SESSION['kogused'][$id].'"> <b>'.$sNimetus.'</b> <a href="'.mGetWordpressBasedData('guid').'&del_id='.$id.'">[X]</a> ('.$_SESSION['kogused'][$id].' x '.$_SESSION['hind'][$id].' = '.($_SESSION['kogused'][$id]*$_SESSION['hind'][$id]).' €)<br />';
		}
		$html .= '<input type="submit" class="shop-submit" value="Kinnita kogused" name="kogused_saadetud"></form>';
		echo $html;
		}
}
add_shortcode( 'kogused', 'mProductQuantity' );


/**
** A base module for [hidden], [hidden*]
**/

/* Shortcode handler */

function wpcf7_hidden_shortcode_handler( $tag ) {
	if ( ! is_array( $tag ) )
		return '';

	$type = $tag['type'];
	$name = $tag['name'];
	$options = (array) $tag['options'];
	$values = (array) $tag['values'];

	if ( empty( $name ) )
		return '';

	$atts = '';
	$id_att = '';
	$class_att = '';
	$size_att = '';
	$maxlength_att = '';
	$tabindex_att = '';
	$title_att = '';

	$class_att .= ' wpcf7-hidden';

	if ( 'hidden*' == $type )
		$class_att .= ' wpcf7-validates-as-required';

	foreach ( $options as $option ) {
		if ( preg_match( '%^id:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
			$id_att = $matches[1];

		} elseif ( preg_match( '%^class:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
			$class_att .= ' ' . $matches[1];
		}
	}

	$value = (string) reset( $values );

	if ( wpcf7_script_is() && $value && preg_grep( '%^watermark$%', $options ) ) {
		$class_att .= ' wpcf7-use-title-as-watermark';
		$title_att .= sprintf( ' %s', $value );
		$value = '';
	}

	if ( wpcf7_is_posted() )
		$value = stripslashes_deep( $_POST[$name] );

	if ( $id_att ) {
		$id_att = trim( $id_att );
		$atts .= ' id="' . trim( $id_att ) . '"';
	}
	if ( $class_att )
		$atts .= ' class="' . trim( $class_att ) . '"';

	global $post;
	if(is_object($post)) {
		if (strtolower($value) == 'post_title' || strtolower($value) == 'post-title') { $value = $post->post_title; }
		if (strtolower($value) == 'post_url') { $value = $post->guid; }
		if (strtolower($value) == 'post_category') {
			$categories = get_the_category();$catnames = array();
			foreach($categories as $cat) { $catnames[] = $cat->cat_name; }
			if(is_array($catnames)) { $value = implode(', ', $catnames); }
		}
		if (strtolower($value) == 'post_author') { $value = $post->post_author; }
		if (strtolower($value) == 'post_date') { $value = $post->post_date; }
		if (preg_match('/^custom_field\-(.*?)$/ism', $value)) {
			$custom_field = preg_replace('/custom_field\-(.*?)/ism', '$1', $value);
			$value = get_post_meta($post->ID, $custom_field, true) ? get_post_meta($post->ID, $custom_field, true) : '';
		}
	}
	
	$value = apply_filters('wpcf7_hidden_field_value', apply_filters('wpcf7_hidden_field_value_'.$id_att, $value));

	$html  = '<input type="hidden" name="' . $name . '" value="' . mArraytoText($_SESSION['tooted'], $_SESSION['kogused']) . '"' . $atts . ' />';
	return $html;
}


/* Tag generator */

add_action( 'admin_init', 'wpcf7_add_tag_generator_hidden', 30 );

function wpcf7_add_tag_generator_hidden() {
	if(function_exists('wpcf7_add_tag_generator')) {
		wpcf7_add_tag_generator( 'hidden', __( 'Hidden field', 'wpcf7' ),
		'wpcf7-tg-pane-hidden', 'wpcf7_tg_pane_hidden' );
	}
}

function wpcf7_tg_pane_hidden() {
?>

<div id="wpcf7-tg-pane-hidden" class="hidden">
<form action="">

<table>
<tr><td><?php echo esc_html( __( 'Name', 'wpcf7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td><td></td></tr>

<tr>
<td><code>id</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
<input type="text" name="id" class="idvalue oneline option" /></td>
</tr>

<tr>
<td><?php echo esc_html( __( 'Default value', 'wpcf7' ) ); ?> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br /><input type="text" name="values" class="oneline" /></td>

<td>
<br /><input type="checkbox" name="watermark" class="option" />&nbsp;<?php echo esc_html( __( 'Use this text as watermark?', 'wpcf7' ) ); ?>
</td>
</tr>
</table>

<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?><br /><input type="text" name="hidden" class="tag" readonly="readonly" onfocus="this.select()" /></div>

<div class="tg-mail-tag"><?php echo esc_html( __( "And, put this code into the Mail fields below.", 'wpcf7' ) ); ?><br /><span class="arrow">&#11015;</span>&nbsp;<input type="text" class="mail-tag" readonly="readonly" onfocus="this.select()" /></div>
</form>
</div>
<?php
}
?>