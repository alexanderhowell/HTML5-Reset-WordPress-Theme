<?php

/**
functions.php

		
*/
	
// Change the RiH Login screen
add_action("login_head", "my_login_head");
function my_login_head() {
	echo "
	<style>
	body {background-color:#fff !important}
	body.login #login h1 a { 		background: url('".get_bloginfo('template_url')."/images/logo.png') no-repeat scroll center top transparent; 		height: 115px; 		width: 300px;  	}
	</style>
	";
}
	function my_theme_add_editor_styles() {
		add_editor_style( 'custom-editor-style.css' );
	}
	add_action( 'init', 'my_theme_add_editor_styles' );



// Enable static serving of content; if we specify static location for ngix files.

if(file_exists(ABSPATH.'/resources/')) {
		add_filter('template_directory_uri','ngix_link');
		// add_filter('stylesheet_uri','ngix_link');
}
function ngix_link($url) {
	return str_replace('wp-content/themes/ocfs', 'resources', $url);
}


/** In main plugin file **/

add_action('admin_print_scripts', 'do_jslibs' );
add_action('admin_print_styles', 'do_css' );

function do_css()
{
    wp_enqueue_style('thickbox');
}

function do_jslibs()
{
    wp_enqueue_script('editor');
    wp_enqueue_script('thickbox');
    add_action( 'admin_head', 'wp_tiny_mce' );
}
/*
/** Then wherever needed **/
    /* 'content' is the id of the control  and the name of the
<div id="poststuff">
    <?php the_editor('<h2>Some content</h2>','content'); ?>
</div>
        hidden textarea created.*/

$awh_globals = array();

	

	// Let's set our thumbnail sizes...
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' ); 
	
	
	add_theme_support( 'post-thumbnails' ); 
	
	
	
	set_post_thumbnail_size( 130, 130, true ); // default Post Thumbnail dimensions (cropped)
	add_image_size( 'coverpage-thumb-large', 466, 257, true ); //
	add_image_size( 'coverpage-thumb-small', 230, 150, true ); //
	add_image_size( 'coverpage-thumb-medium', 230, 215, true ); //
	add_image_size( 'square-small', 110, 110, true ); //
} else error_log('RIH theme needs thumbmail support- update your WP!');

	// ...and add such things as default thumbnails...
add_filter( 'post_thumbnail_html', 'awh_thumb' , 1, 5);
function awh_thumb($html, $post_id, $post_thumbnail_id, $size, $attr = array('class' => '') ) {
	if(!is_array($attr) || !isset($attr['class'])) $attr['class'] = '';
	if($html == '') {
		$attrs = ' ';
		foreach($attr as $key => $val) $attrs .= $key.'="'.$val.'" ';
		
		return '<img class="defaulted '.$attr["class"].' attachment-'.$size.' wp-post-image" src="'.get_stylesheet_directory_uri().'/images/default-'.$size.'.png" '.$attrs.'>';
	}
	else return $html;
}


	// And we'll also rename our "posts" to articles with these two actions and functions
add_action( 'admin_menu', 'change_post_menu_label' );

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Articles';
    $submenu['edit.php'][5][0] = 'News Articles';
    $submenu['edit.php'][10][0] = 'Add News Article';
    $submenu['edit.php'][15][0] = 'Categories'; // Change name for categories
    $submenu['edit.php'][16][0] = 'Tags'; // Change name for tags
	$restricted = array(__('Links'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL ? $value[0] : "" , $restricted)){unset($menu[key($menu)]);}
	}
}

	register_nav_menus( array(
		'awh_header' => 'Header Menu',
		'awh_footer' => 'Footer Menu'
	) );

	// Lets make sure we can create decent looking menus. Add some walker classes.
//require('functions_walkers.php');

	// The RIH theme might occasionally need some global variables- let's create a sensible namespace for them in PHP scope, and add them to the database
global $awh_options;

	// Add in the administrators bits and pieces
//if ( is_admin() ) require('functions_admin.php');


register_sidebar(array(
	'id'=>'article',
	'name'=>'Article',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="mast">',
	'after_title' => '</h3>',
));

register_sidebar(array(
	'id'=>'footer',
	'name'=>'Footer',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="mast">',
	'after_title' => '</h3>',
));

register_sidebar(array(
	'id'=>'home',
	'name'=>'Home',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

register_sidebar(array(
	'id'=>'page',
	'name'=>'Pages',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));



?>
