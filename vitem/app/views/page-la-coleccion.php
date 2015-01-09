<?php //paso variables globales para identificar d�nde estamos y qu� mostrar, ejem, el header o men�
global $bodyD, $hdr_css_xtra, $hdr_js_xtra;
$bloginfoo = get_bloginfo('template_directory');
$bodyD = '';
$hdr_css_xtra = '<link rel="stylesheet" href="'. $bloginfoo . '/css/galleria.classic.css" type="text/css" />';
?>

<?php
/*
Template Name: Colecci&oacute;n
*/
?>

<?php get_header(); ?>

<?php 
	$args = array(
        'type'                     => 'coleccion',
        'taxonomy'                 => 'coleccion_category',
    ); 

	$categories = get_categories( $args );
    
?>

<?php //if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $codigoc = get_field(codigoc); ?>

<!-- Contenido -->
<div class="hldr-cont">

	<br class="clear" />
<br class="clear" />

<div class="fltLC">
	<ul>
		<?php foreach($categories as $kc => $c) { ?>

			<li><a class="galleria-tabs" id="tab_<?php echo $c->slug; ?>" href="#" style="text-transform: uppercase; font-size: 22px; text-align: center; "><?php echo $c->name; ?></a></li>

		<?php } ?>
		<!--<li><a class="first" href="#" ><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_1.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/metal/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_2.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/madera/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_3.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/fibra-vegetal/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_4.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/piedra/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_5.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/papel/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_6.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/piel/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_7.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/textiles/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_8.jpg" /></a></li>
		<li><a href="http://www.fomentoculturalbanamex.org/gmapi_en/la-coleccion/varios/"><img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/col_mnu_9.jpg" /></a></li>-->
	</ul>
	<div class="inG" style="text-transform: uppercase; transform: rotate(-90deg); width: 560px; height: 70px; font-size: 69px; position: absolute; top: 347px; left: -241px; color: #6E6E6E;" > The Collection </div>
	<div class="inG" style="width: 1px; position: relative; top: -20px; left: 80px; height: 680px; background-color: #6E6E6E; " > </div>
	<!--<img src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/coleccion1.jpg" class="inG" />	-->
</div>

	<!-- Galería -->
		<?php foreach($categories as $kc => $c) { ?>

			<div id="galleria_<?php echo $c->slug; ?>" class="galleria" >
				<?php 

				query_posts(array(
					'post_type' => 'coleccion',
					'coleccion_category' => $c->slug
				));

				if (have_posts()) : while (have_posts()) : the_post();	

				$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );		

				if($url){	

				?>			
	            <a href="<?php echo $url; ?>">
	            	<img title=""
	            	     alt="<?php echo get_the_content(); ?>"
	            	     src="<?php echo $url; ?>">

	        	</a>

	        	<?php 

	        	}

	        	endwhile; endif;

	        	?>
        	</div>

		<?php } ?>
        <!--<div id="galleria">
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO1.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO1.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO2.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO2.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO3.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO3.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO4.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO4.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO5.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO5.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO6.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO6.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO7.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO7.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO8.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO8.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO9.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO9.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO10.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO10.jpg">
        	</a>

            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO11.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO11.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO12.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO12.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO13.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO13.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO14.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO14.jpg">
        	</a>
            <a href="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO15.jpg">
            	<img title="Pie de Foto"
            	     alt="Nombre y Autor de la Pieza"
            	     src="http://www.fomentoculturalbanamex.org/gmapi_en/wp-content/themes/grandesmaestros/img/gals/barro/BARRO15.jpg">
        	</a>
        </div>-->
	<!-- Galería -->


<br class="clear" />
<br class="clear" />

	<?php // the_content(); ?>
	
	<?php //echo $codigoc; ?>
	
<!-- AddThis 
<div class="addthis_toolbox addthis_default_style addSoc">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
 AddThis Button END -->
<?php //echo do_shortcode('[addtoany]'); ?>
	
	<?php //edit_post_link('Editar esta p&aacute;gina.', '<br /><br /><p>', '</p>'); ?>

</div>
<!-- Contenido -->

		<?php //endwhile; ?>
	<?php //endif; ?>
	
<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/js/galleria-1.2.6.min.js'></script>

    <script>

    // Load the classic theme
	Galleria.loadTheme('<?php bloginfo('template_directory'); ?>/js/galleria.classic.min.js');

	// Initialize Galleria

	<?php foreach($categories as $kc => $c) { ?>
	$('#galleria_<?php echo $c->slug; ?>').galleria({
		showInfo: true,
		transition: 'flash'
	});
	<?php } ?>

	$(".galleria").hide();

	$(".galleria-tabs").click( function (e){

		e.preventDefault();

		var id = $(this).attr('id');

		id = id.replace('tab_' , '');

		$(".galleria").hide();

		$("#galleria_"+id).show();

	} );

	$(document).ready(function(){



		$(".galleria:first").show();

	})

	

    </script>

<?php get_footer(); ?>
