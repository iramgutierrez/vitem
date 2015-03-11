<?php //paso variables globales para identificar dónde estamos y qué mostrar, ejem, el header o menú
global $bodyD, $headerinr, $hdr_css_xtra, $hdr_js_xtra;
$bloginfoo = get_bloginfo('template_directory');
$bodyD = '';
$headerinr = ' zIx';
//$hdr_css_xtra = '<link rel="stylesheet" href="'. $bloginfoo .'/css/interiores.css" type="text/css" />';
$hdr_css_xtra = '';
$hdr_js_xtra = '<script type="text/javascript" src="'. $bloginfoo .'/js/jquery.cycle.lite.js"></script>';
?>

<?php
/*
Template Name: Presentacion
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- Contenido -->
<div class="hldr-cont">

	<?php the_content(); ?>
	
	<?php edit_post_link('Editar esta p&aacute;gina.', '<br /><br /><p>', '</p>'); ?>

</div>
<!-- Contenido -->

		<?php endwhile; ?>
	<?php endif; ?>
	
<script>
$(document).ready(function() {
	$("#slideshowPr").css("overflow", "hidden");
	
	$("ul#slides").cycle({
		fx: 'fade',
		pause: 1,
		prev: '#prev',
		next: '#next'
	});
	
	$("#slideshowPr").hover(function() {
    	$("ul#nav").fadeIn();
  	},
  		function() {
    	$("ul#nav").fadeOut();
  	});
	
})
</script>

<?php get_footer(); ?>