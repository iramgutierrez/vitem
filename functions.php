<?php
/**
 * EMS 2014 functions and definitions
 *
 */

add_action( 'init', 'codex_producto_init' );
add_theme_support( 'post-thumbnails' ); 

include 'theme_customizer.php';
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_producto_init() {
	$labels = array(
		'name'               => _x( 'Productos', 'productos', 'productos' ),
		'singular_name'      => _x( 'Producto', 'producto', 'productos' ),
		'menu_name'          => _x( 'Productos', 'admin menu', 'productos' ),
		'name_admin_bar'     => _x( 'Producto', 'add new on admin bar', 'productos' ),
		'add_new'            => _x( 'Agregar nuevo', 'producto', 'productos' ),
		'add_new_item'       => __( 'Agregar nuevo producto', 'productos' ),
		'new_item'           => __( 'Nuevo producto', 'productos' ),
		'edit_item'          => __( 'Editar producto', 'productos' ),
		'view_item'          => __( 'Ver producto', 'productos' ),
		'all_items'          => __( 'Todos los productos', 'productos' ),
		'search_items'       => __( 'Buscar producto', 'productos' ),
		'not_found'          => __( 'No se encontraron productos.', 'productos' ),
		'not_found_in_trash' => __( 'No se encontraron productos en papelera.', 'productos' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'producto' ),
		'capability_type'    => 'post',
		'taxonomies' => array('category_product'), 
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail', 'excerpt' , 'editor' , 'thumbnail' ,'custom-fields')
	);

	register_post_type( 'producto', $args );
}

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_producto_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_producto_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Categoría de producto', 'taxonomy general name' ),
		'singular_name'     => _x( 'category_product', 'taxonomy singular name' ),
		'search_items'      => __( 'Buscar categoría de productos' ),
		'all_items'         => __( 'Todas las categorías de productos' ),
		'parent_item'       => __( 'Categoría de productos padre' ),
		'parent_item_colon' => __( 'Categoría de productos padre:' ),
		'edit_item'         => __( 'Editar categoría de productos:' ),
		'update_item'       => __( 'Actualizar categoría de productos' ),
		'add_new_item'      => __( 'Agregar categoría de productos' ),
		'new_item_name'     => __( 'Nuevo nombre de categoría de productos' ),
		'menu_name'         => __( 'Categoría de productos' ),
	);

	$args = array(
		'labels'            => $labels,
		'show_ui'           => true,
		'hierarchical' => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 
			'slug' => 'category_product' 
		)
	);

	register_taxonomy( 'category_product', array( 'producto' ), $args );

}
 ?>