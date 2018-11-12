<div id="right-content">

<div class="sidemenu">
<h2>Tootegrupid:</h2>

<?php 
//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)

$taxonomy     = 'tootegrupid';
$orderby      = 'name'; 
$show_count   = 1;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$hide_empty	  = 0;

$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'	 => $hide_empty
);
?>

<ul class="shop-menu">
	<?php wp_list_categories( $args ); ?>
</ul>


</div>

<div class="sidemenu-cart">
	<a href="http://www.rannarahvamuuseum.ee/tellimuse-kinnitus/"><img src="<?php bloginfo('template_directory'); ?>/shopcart.png" class="cart" alt="Ostukorv" /><br /><br />

<?php echo mShoppingCartSidebar(); ?>

</a>
</div>


<!-- <div class="sidemenu">
<h2>Sündmused</h2>
<a href="http://www.rannarahvamuuseum.ee/index.php?id=14">Vaata mis on toimumas</a>
<a href="http://www.rannarahvamuuseum.ee/index.php?id=199">Sündmuste arhiiv</a>
</div>
<div class="sidebox">
<h2>SAADA KIRI / TELLIMUS</h2>
<form id="query-form" action="index.php" method="post">
<input type="text" name="nimi" id="name" value="Nimi:" onclick="if(this.value=='Nimi:'){this.value='';}" onblur="if(this.value==''){this.value='Nimi:';}" />
<input type="text" name="tel" id="phone" value="Telefoni number:" onclick="if(this.value=='Telefoni number:'){this.value='';}" onblur="if(this.value==''){this.value='Telefoni number:';}" />

<input type="text" name="email" id="email" value="E-post:" onclick="if(this.value=='E-post:'){this.value='';}" onblur="if(this.value==''){this.value='E-post:';}" />
<textarea name="tekst" id="query" cols="40" rows="5" onclick="if(this.value=='Tekst:'){this.value='';}" onblur="if(this.value==''){this.value='Tekst:';}">Tekst:</textarea>
<div class="button" onclick="document.getElementById('query-form').submit();" style="float:right;" title="Saada">SAADA</div>
</form>
</div> -->

</div>
<br clear="all" />
</div>

<div id="contact">Nurme tee 3<br />Pringi k&uuml;la<br />Viimsi vald<br />74011 HARJUMAA<br />info@rannarahvamuuseum.ee<br />Tel / faks 6066 941</div>
