<?php
/********************* DEFINE MAIN PATHS ********************/
//error_reporting(-1);
define('Maxshop_PLUGINS',  get_template_directory() . '/addons' ); // Shortcut to the /addons/ directory

$adminPath 	=  get_template_directory() . '/library/admin/';
$funcPath 	=  get_template_directory() . '/library/functions/';
$incPath 	=  get_template_directory() . '/library/includes/';

global $alc_options;
$alc_options = isset($_POST['options']) ? $_POST['options'] : get_option('alc_general_settings');

/************************************************************/


/************* LOAD REQUIRED SCRIPTS AND STYLES *************/
function maxshop_loadScripts()
{
	$alc_options = isset($_POST['options']) ? $_POST['options'] : get_option('alc_general_settings');
	if( $GLOBALS['pagenow'] != 'wp-login.php' && !is_admin())
	{         
		wp_enqueue_style('tooltipster',  get_template_directory_uri().'/css/tooltipster.css');
		wp_enqueue_style('ie', get_template_directory_uri().'/css/ie.css');
		wp_enqueue_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css');
		wp_enqueue_style('bootstrap-responsive', get_template_directory_uri().'/css/bootstrap-responsive.css');
		wp_enqueue_style('main-styles', get_stylesheet_directory_uri().'/style.css');
		wp_enqueue_style('responsive',  get_template_directory_uri().'/responsive.css');
		
		wp_enqueue_style('prettyphoto',  get_template_directory_uri().'/css/prettyPhoto.css');
		wp_enqueue_style('dynamic-styles',  get_template_directory_uri().'/css/dynamic-styles.php');
		wp_enqueue_style('font-awesome',  get_template_directory_uri().'/addons/fontawesome/css/font-awesome.min.css');
        wp_enqueue_style('font-awesome',  get_template_directory_uri().'/css/themes/default/default.css');
		wp_enqueue_style('jplayer-styles',  get_template_directory_uri().'/js/jplayer/skin/pink.flag/jplayer.pink.flag.css',false,'3.0.1','all');
        
		// Register or enqueue scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('modernizr', get_template_directory_uri() .'/js/modernizr.custom.17475.js');
		wp_enqueue_script('bootstrap',  get_template_directory_uri(). '/js/bootstrap.min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('jquery-ui',  get_template_directory_uri(). '/js/jquery-ui.js', array('jquery'), '3.2', true);
        wp_enqueue_script('jquery-cycle', get_template_directory_uri() .'/js/jquery.cycle.all.js', array('jquery'), '3.2', true);
		wp_enqueue_script('flex-slider', get_template_directory_uri() .'/js/jquery.flexslider-min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('jplayer-audio',  get_template_directory_uri().'/js/jplayer/jquery.jplayer.min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('elastislide', get_template_directory_uri() .'/js/jquery.elastislide.js', array('jquery'), '3.2', true);
		wp_enqueue_script('carouFredSel',  get_template_directory_uri(). '/js/jquery.carouFredSel-6.0.4-packed.js', array('jquery'), '3.2', true);
		wp_enqueue_script('selectBox', get_template_directory_uri() .'/js/jquery.selectBox.js', array('jquery'), '3.2', true);
		wp_enqueue_script('tooltipster', get_template_directory_uri() .'/js/jquery.tooltipster.min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('mobile-menu', get_template_directory_uri() .'/js/jquery.mobilemenu.min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('prettyphoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js', array('jquery'), '3.2', true);
		wp_enqueue_script('custom', get_template_directory_uri() .'/js/custom.js', array('jquery'), '3.2', true);
		wp_enqueue_script('Validate',  get_template_directory_uri().'/js/jquery.validate.min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('flickr', get_template_directory_uri().'/addons/flickr/jflickrfeed.min.js', array('jquery'), '3.2', true);
     	if (is_page_template('contact-template.php')){
			$alc_options = get_option('alc_general_settings'); 
			if (!empty($alc_options['alc_contact_address']))
			{
				wp_enqueue_script('Google-map-api',  'http://maps.google.com/maps/api/js?sensor=false');
				wp_enqueue_script('Google-map',  get_template_directory_uri().'/js/gmap3.min.js', array('jquery'), '3.2', true);
			}			
		}		
		if (is_page_template('under-construction.php'))
		{
			wp_enqueue_script('Under-construction',  get_template_directory_uri().'/js/jquery.countdown.js', array('jquery'), '3.2', true);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'maxshop_loadScripts' ); //Load All Scripts

function maxshop_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'maxshop-opensans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:300,700,600,800" );
    wp_enqueue_style( 'maxshop-oswald', "$protocol://fonts.googleapis.com/css?family=Oswald:400,700" );
    wp_enqueue_style( 'maxshop-quattrocento', "$protocol://fonts.googleapis.com/css?family=Quattrocento:400,700" );
    
    }
add_action( 'wp_enqueue_scripts', 'maxshop_fonts' );

/************************************************************/


/********************* DEFINE MAIN PATHS ********************/

require_once ($funcPath . 'helper.php');
require_once ($incPath . 'the_breadcrumb.php');
require_once ($incPath . 'OAuth.php');
require_once ($incPath . 'twitteroauth.php');
require_once ($funcPath . 'options.php');
require_once ($funcPath . 'post-types.php');
require_once ($funcPath . 'widgets.php');
require_once ($funcPath . 'sidebar-generator.php');
require_once ($funcPath . '/shortcodes/shortcode.php');
require_once ($adminPath . 'custom-fields.php');
require_once ($adminPath . 'scripts.php');
require_once ($adminPath . 'admin-panel/admin-panel.php');
// Redirect To Theme Options Page on Activation
if (is_admin() && isset($_GET['activated'])){
	wp_redirect(admin_url('admin.php?page=adminpanel'));

}

/************************************************************/


/*************** AFTER THEME SETUP FUNCTIONS ****************/

add_action( 'after_setup_theme', 'maxshop_setup' );
function maxshop_setup() {
	// Language support 
	load_theme_textdomain( 'Maxshop',  get_template_directory() . '/languages' );
	$locale = get_locale();
	$locale_file =  get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) ){
		require_once( $locale_file );
	}
	
	// ADD SUPPORT FOR POST THUMBS 
	add_theme_support( 'post-thumbnails');
	// Define various thumbnail sizes
	add_image_size('blog-list1', 740, 350, true); 
	add_image_size('blog-thumb', 50, 50, true);

	//ADD SUPPORT FOR WORDPRESS 3 MENUS ************/

	add_theme_support( 'menus' );
	//Register Navigations
	add_action( 'init', 'my_custom_menus' );
	function my_custom_menus() {
		register_nav_menus(
			array(
				'primary_nav' => __( 'Primary Navigation', 'Maxshop'),
				'top_nav'=>__('Top Navigation', 'Maxshop'),
			)
		);
	}
}

/************************************************************/


/****************** WOOCommerce HOOKS ***********************/

add_theme_support( 'woocommerce' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


remove_action( 'woocommerce_after_main_content', 'woocommerce_catalog_ordering', 10 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 20 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_title', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

function maxshop_woocommerce_catalog_page_ordering() {

	global $wp_query;
	$paged    = max( 1, $wp_query->get( 'paged' ) );
	$per_page = $wp_query->get( 'posts_per_page' );
	$total    = $wp_query->found_posts;
			
	?>
	<?php if ($total > 2):?>
		<div class="sort-select">
			<form action="" method="POST" name="results">
				<label><?php _e('Show', 'Maxshop')?></label>
				<select name="woocommerce-sort-by-columns" id="woocommerce-sort-by-columns" class="sortby" onchange="this.form.submit()">
				<?php

				//  This is where you can change the amounts per page that the user will use 
				// feel free to change the numbers and text as you want, in my case we had 4 products per row so I chose to have multiples of four for the user to select.
				
					$shopCatalog_orderby = apply_filters('woocommerce_sortby_page', array(
						''       => __('Results per page', 'Maxshop'),
						'2' 	=> __('2 per page', 'Maxshop'),
						'4' 	=> __('4 per page', 'Maxshop'),
						'12' 	=> __('12 per page', 'Maxshop'),
						'24' 	=> __('24 per page', 'Maxshop'),
						'36' 	=> __('36 per page', 'Maxshop'),
						'48' 	=> __('48 per page', 'Maxshop'),
						'64' 	=> __('64 per page', 'Maxshop'),
					));

					foreach ( $shopCatalog_orderby as $sort_id => $sort_name )
						echo '<option value="' . $sort_id . '" ' . selected($_SESSION['shop_pageResults'], $sort_id, false ) . ' >' . $sort_name . '</option>';
				?>
				</select>
			</form>
		</div>
		
	<?php endif?>
	
<?php

} 

// now we set our cookie if we need to
function maxshop_sort_by_page($count) {
	$al_options = get_option('alc_general_settings'); 
	$count = (isset($al_options['alc_wooppp']) && $al_options['alc_wooppp'] !='') ? $al_options['alc_wooppp'] : '8';
 
  if (isset($_SESSION['shop_pageResults']) && $_SESSION['shop_pageResults'] !== '') { // if normal page load with cookie
     $count = $_SESSION['shop_pageResults'];
  }
  if (isset($_POST['woocommerce-sort-by-columns'])) { //if form submitted
    //setcookie('shop_pageResults', $_POST['woocommerce-sort-by-columns'], time()+1209600, '/',  get_site_url(), false);
    $count = $_POST['woocommerce-sort-by-columns'];
	if (!empty($count))
	$_SESSION['shop_pageResults'] = $count;
  }
  // else normal page load and no cookie
  return $count;
}

add_filter('loop_shop_per_page','maxshop_sort_by_page');
add_action( 'woocommerce_before_shop_loop', 'maxshop_woocommerce_catalog_page_ordering', 20 );

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'maxshop_woocommerce_image_dimensions', 1 );
 
/**
 * Define image sizes
 */
function maxshop_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '270',	// px
		'height'	=> '180',	// px
		'crop'		=> 1 		// true
	);
 
	$single = array(
		'width' 	=> '600',	// px
		'height'	=> '600',	// px
		'crop'		=> 1 		// true
	);
 
	$thumbnail = array(
		'width' 	=> '270',	// px
		'height'	=> '180',	// px
		'crop'		=> 0 		// false
	);
 
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

// Change number or products per row
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		$al_options = get_option('alc_general_settings'); 
		$columns = (isset($al_options['alc_woocolumns']) && $al_options['alc_woocolumns'] !='') ? $al_options['alc_woocolumns'] : '4';
		return $columns;
	}
}

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) {
global $woocommerce;
ob_start();
?>
<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
<?php

$fragments['a.cart-contents'] = ob_get_clean();

return $fragments;

}

/************************************************************/


/******************* FILL EMPTY WIDGET TITLE ****************/

function Maxshop_fill_widget_title($title){
	if( empty( $title ) )
		return ' ';
	else return $title;
}
add_filter('widget_title', 'Maxshop_fill_widget_title');

add_theme_support( 'automatic-feed-links' );
if ( ! isset( $content_width ) ) $content_width = 960;

/************************************************************/
?>
/************************Widget new post***************************/
class my_widget extends WP_Widget
{
  function my_widget()
  {
    $widget_ops = array(
          'classname' => 'my_widget', 
          'description' => 'Hiển thị bài viết ngẫu nhiên' );
    $this->WP_Widget('my_widget', 'Random Post', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
<?php
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // CODE CỦA WIDGET ĐẶT Ở ĐÂY
 
    echo $after_widget;
  } 
}
add_action( 'widgets_init', create_function('', 'return register_widget("my_widget");') );
?>